<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    //les champs du formulaire a complete
    protected $fillable=["nom"];
    protected $table = 'role';
    public $timestamps = false;
    public function user()
    {
        
        return $this->belongsTo(User::class);
    }
}