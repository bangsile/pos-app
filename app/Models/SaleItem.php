<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasUuids;

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price',
        'subtotal'
    ];
}
