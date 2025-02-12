<?php

namespace App\Models;

use App\Enums\Status;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    use Sluggable;

    protected $casts = [
        'status' => Status::class,
    ];

    protected $fillable = [
        'slug',
        'name',
        'description',
        'photo',
        'status',
        'created_at',
        'updated_at',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }

    public function waitproducts()
    {
        return $this->hasMany(WaitProduct::class, 'brand_id', 'id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }
}
