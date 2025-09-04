<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasUuids;

    protected $fillable = [
        'company_id',
        'name',
        'address',
        'phone'
    ];

    // Scope
    public function scopeSearch($query, $term)
    {
        if (empty($term))
            return $query; // tidak filter apapun

        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', '%' . $term . '%');
        });
    }

    // Relaitons
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
