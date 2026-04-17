<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $fillable = ['name', 'priority'];


    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'rank_permission', 'rank_id', 'permission_id');
    }
}
