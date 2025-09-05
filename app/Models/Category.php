<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasUuids;

    protected $fillable = ['company_id', 'name'];

    // Scope
    public function scopeSearch($query, $term)
    {
        if (empty($term))
            return $query; // tidak filter apapun

        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', '%' . $term . '%');
        });
    }

    // Relasi
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
