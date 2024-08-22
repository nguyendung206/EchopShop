<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
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
        'day_of_issue',
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

    protected $hidden = [
        'password',
    ];

}



