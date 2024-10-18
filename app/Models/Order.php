<?php

namespace App\Models;

use App\Enums\CancelOrderReason;
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
        'province_id',
        'district_id',
        'ward_id',
        'cancel_reason',
    ];

    protected $casts = [
        'type_payment' => TypePayment::class,
        'status' => StatusOrder::class,
        'cancel_reason' => CancelOrderReason::class,
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
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
}
