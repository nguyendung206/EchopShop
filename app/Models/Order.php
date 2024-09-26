<?php

namespace App\Models;

use App\Enums\StatusOrder;
use App\Enums\TypePayment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_amount',
        'status',
        'type_payment',
        'shipping_address',
        'user_id',
        'discount_id',
        'message',
    ];

    protected $casts = [
        'type_payment' => TypePayment::class,
        'status' => StatusOrder::class,
    ];
}
