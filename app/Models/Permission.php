<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name_permission'];

    public function ranks()
    {
        return $this->belongsToMany(Rank::class, 'rank_permission', 'permission_id', 'rank_id');
    }
}
