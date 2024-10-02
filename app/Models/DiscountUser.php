<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountUser extends Model
{
    use HasFactory;

    protected $table = 'discount_user';
    
    protected $fillable = [
        'user_id',
        'discount_id',
        'number_used'
    ];
}
