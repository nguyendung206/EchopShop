<?php

namespace App\Models;

use App\Enums\Status;
use App\Enums\TypeProduct;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $casts = [
        'status' => Status::class,
        'type' => TypeProduct::class,
        'list_photo' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function colors()
    {
        return $this->hasMany(ProductUnit::class)->where('type', 'color');
    }

    public function sizes()
    {
        return $this->hasMany(ProductUnit::class)->where('type', 'size');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
