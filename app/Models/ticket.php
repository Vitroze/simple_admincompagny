<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    //les champs du formulaire a complete
    protected $fillable=["description","statut","date_tiket","user_id"];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isClosed()
    {
        return $this->statut === 'ferme';
    }
}
