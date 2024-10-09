<?php

namespace App\Models;

use App\Enums\Status;
use App\Enums\TypeProduct;
use App\Enums\TypeProductUnit;
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

    public function productUnits()
    {
        return $this->hasMany(ProductUnit::class, 'product_id', 'id');
    }

    public function getProductUnitTypeOne()
    {
        foreach ($this->productUnits as $productUnit) {
            if ($productUnit->type == typeProductUnit::ONLYQUANTITY->value) {
                return $productUnit;
            }
        }

        return null;
    }

    public function hasQuantityProduct()
    {
        $productUnits = $this->productUnits;

        foreach ($productUnits as $productUnit) {
            if ($productUnit->quantity > 0) {
                return true;
            }
        }

        return false;
    }

    public function getProductUnitById($unitId)
    {
        return $this->productUnits()->where('id', $unitId)->first();
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id', 'id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
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
