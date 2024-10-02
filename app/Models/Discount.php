<?php

namespace App\Models;

use App\Enums\Status;
use App\Enums\TypeDiscount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'code',
        'type',
        'value',
        'max_value',
        'start_time',
        'end_time',
        'max_uses',
        'photo',
        'quantity_used',
        'limit_uses',
        'status',
    ];

    protected $casts = [
        'type' => TypeDiscount::class,
        'status' => Status::class,
    ];

    public function discountUsers()
    {
        return $this->hasMany(DiscountUser::class, 'discount_id', 'id');
    }

    public function getDiscountUserByUserId($userId)
    {
        return $this->discountUsers()->where('user_id', $userId)->first();
    }
}
