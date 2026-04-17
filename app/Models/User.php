<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canTargetUser(User $targetUser): bool
    {
        $currentUserRank = Rank::where('name', $this->usergroup)->first();
        $targetUserRank = Rank::where('name', $targetUser->usergroup)->first();

        if (!$currentUserRank || !$targetUserRank) {
            return false;
        }

        return $currentUserRank->priority <= $targetUserRank->priority;
    }

    public function hasPermission($permissionName, User $targetUser = null): bool
    {
        $rank = Rank::where('name', $this->usergroup)->first();
        if (!$rank) {
            return false;
        }

        $permissions = $rank->permissions()->pluck('name_permission')->toArray();
        if (!in_array($permissionName, $permissions)) {
            return false;
        }

        if ($targetUser && !$this->canTargetUser($targetUser)) {
            return false;
        }

        return true;
    }
}
