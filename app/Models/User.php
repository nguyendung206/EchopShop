<?php

namespace App\Models;

use App\Enums\Status;
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
        'address',
        'province_id',
        'district_id',
        'ward_id',
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

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
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
}
