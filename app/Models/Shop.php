<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => Status::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'shop_id', 'id');
    }

    public function waitproducts()
    {
        return $this->hasMany(WaitProduct::class, 'shop_id', 'id');
    }
}
