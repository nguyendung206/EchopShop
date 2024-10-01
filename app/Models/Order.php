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
    ];

    protected $casts = [
        'type_payment' => TypePayment::class,
        'status' => StatusOrder::class,
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }
}
