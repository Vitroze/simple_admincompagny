<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Dialogue extends Model
{

    //les champs du formulaire a complete
    protected $fillable=["reponse","ticket_id","user_id"];
    protected $table = 'dialogue';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}