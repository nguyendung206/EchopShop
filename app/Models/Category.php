<?php

namespace App\Models;

use App\Enums\Status;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use Sluggable;

    protected $casts = [
        'status' => Status::class,
    ];

    public function brands()
    {
        return $this->hasMany(Brand::class, 'category_id', 'id');
    }

    public function activeBrands() {
        return $this->hasMany(Brand::class, 'category_id', 'id')->where('status', 1);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
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
