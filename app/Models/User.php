<?php

namespace App\Models;

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
}
