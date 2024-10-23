<?php

namespace App\Models;

use App\Enums\Status;
use App\Enums\StatusOrder;
use App\Enums\UserGender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'password',
        'email',
        'avatar',
        'phone_number',
        'citizen_identification_number',
        'date_of_issue',
        'place_of_issue',
        'date_of_birth',
        'gender',
        'rank_id',
        'status',
        'shop_id',
        'role',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => Status::class,
        'gender' => UserGender::class,
    ];

    protected $hidden = [
        'password',
    ];

    public function statusText()
    {
        return $this->status == 0 ? 'Hoạt động' : 'Đã bị khoá';
    }

    public function genderText()
    {
        return $this->status == 0 ? 'Nam' : 'Nữ';
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_id', 'id');
    }

    public function countFavorite()
    {
        return $this->favorites()->count();
    }

    public function shop()
    {
        return $this->hasOne(Shop::class, 'user_id', 'id');
    }

   

    public function carts()
    {
        return $this->hasMany(Cart::class, 'user_id', 'id');
    }

    public function countCart()
    {
        return $this->carts()->count();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id');
    }

    public function countNotification()
    {
        return $this->notifications()->where('is_read', false)->count();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function hasPurchased($productId)
    {
        return $this->orders()
            ->where('status', StatusOrder::COMPLETED)
            ->whereHas('orderDetails', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })->exists();
    }

    public function hasRated($productId)
    {
        return $this->ratings()
            ->where('product_id', $productId)
            ->exists();
    }

    public function addresses()
    {
        return $this->hasMany(ShippingAddress::class, 'user_id');
    }

    public function defaultAddress()
    {
        return $this->hasOne(ShippingAddress::class)->where('is_default', true);
    }
}
