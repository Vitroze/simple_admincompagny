<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $table = 'factures';

    protected $fillable = [
        'reference',
        'client_name',
        'products',
        'total_amount',
        'due_date',
        'status',
    ];
}
