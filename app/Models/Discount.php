<?php

namespace App\Models;

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
    ];

    protected $casts = [
        'type' => TypeDiscount::class,
    ];
}
