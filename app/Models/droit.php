<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Droit extends Model
{

    //les champs du formulaire a complete
    protected $fillable=["user_id","role_id","ticket","gerer_user","inventaire","gerer_facture","parametre"];
    protected $table = 'droit';
    protected $casts = ["ticket"=>'boolean',
                        "gerer_user"=>'boolean',
                        "inventaire"=>'boolean',
                        "gerer_facture"=>'boolean',
                        "parametre"=>'boolean'
                        ];

    public function user()
    {
        
        return $this->belongsTo(User::class);
    }
}