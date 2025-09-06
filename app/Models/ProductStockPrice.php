<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ProductStockPrice extends Model
{
    use HasUuids;

    protected $fillable = ['product_id', 'outlet_id', 'stock', 'price'];
}
