<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasUuids;

    protected $fillable = [
        'company_id',
        'outlet_id',
        'user_id',
        'invoice_number',
        'total',
        'payment_method',
        'paid_amount',
        'change_amount'
    ];
}
