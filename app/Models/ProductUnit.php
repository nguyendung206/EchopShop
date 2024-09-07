<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    use HasFactory, Sluggable;
    protected $table = 'product_units';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function Color($query)
    {
        return $query->where('type', 'color');
    }

    public function Size($query)
    {
        return $query->where('type', 'size');
    }
}
