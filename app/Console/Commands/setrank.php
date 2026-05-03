<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Rank;

#[Signature('app:setrank {user_id} {usergroup}')]
#[Description('Set a user rank')]
class setrank extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user_id = $this->argument('user_id');
        $usergroup = $this->argument('usergroup');

        $user = User::find($user_id);
        if (!$user) {
            $this->error("User not found.");
            return Command::FAILURE;
        }

        $rank = Rank::where('name', $usergroup)->first();
        if (!$rank) {
            $this->error("Rank not found.");
            return Command::FAILURE;
        }
        $user->usergroup = $usergroup;
        $user->save();

        $this->info("User rank set successfully.");
        return Command::SUCCESS;
    }
}

// php artisan app:setrank 1 user