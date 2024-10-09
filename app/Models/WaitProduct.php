<?php

namespace App\Models;

use App\Enums\Status;
use App\Enums\TypeProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitProduct extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => Status::class,
        'type' => TypeProduct::class,
        'list_photo' => 'array',
    ];

    protected $table = 'wait_products';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function waitproductUnits()
    {
        return $this->hasMany(WaitProductUnit::class);
    }
}
