<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasUuids;
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'subscription_plan',
        'subscription_expired_at',
        'status'
    ];
}
