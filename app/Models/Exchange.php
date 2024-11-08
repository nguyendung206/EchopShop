<?php

namespace App\Models;

use App\Enums\StatusExchange;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'exchange_product_id',
        'user_id',
        'receiver_id',
        'status',
        'requested_at',
        'approved_at',
        'completed_at',
    ];

    protected $casts = [
        'status' => StatusExchange::class,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function exchangeProduct()
    {
        return $this->belongsTo(Product::class, 'exchange_product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }
}
