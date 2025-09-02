<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasUuids, SoftDeletes;
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'subscription_plan',
        'subscription_expired_at',
        'status'
    ];

    // Accessor
    public function getRemainingDaysAttribute(): ?int
    {
        if (!$this->subscription_expired_at) {
            return null;
        }

        return remainingDays($this->subscription_expired_at);
    }

    // Relations
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
