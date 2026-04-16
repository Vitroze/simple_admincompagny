<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory_compagny';

    protected $fillable = [
        'product_name',
        'quantity',
        'status',
    ];
}
