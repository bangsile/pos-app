<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasUuids;

    protected $fillable = [
        'company_id',
        'category_id',
        'name',
        'code',
        'barcode',
    ];

    // Scope
    public function scopeSearch($query, $term)
    {
        if (empty($term))
            return $query; // tidak filter apapun

        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', '%' . $term . '%')
                ->orWhere('code', 'like', '%' . $term . '%')
                ->orWhere('barcode', 'like', '%' . $term . '%');
        });
    }

    // Relasi
    public function companies()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
