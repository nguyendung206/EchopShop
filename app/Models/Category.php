<?php

namespace App\Models;

use App\Enums\CategoryStatus;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use Sluggable;
    
    protected $casts = [
        'status' => CategoryStatus::class,
    ];

    public function brands()
    {
        return $this->hasMany(Brand::class, 'category_id', 'id');
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
