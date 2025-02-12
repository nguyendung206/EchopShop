<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins'; // Tên bảng tương ứng

    protected $fillable = [
        'name',
        'email',
        'password',
        'avarta',
        'status',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
