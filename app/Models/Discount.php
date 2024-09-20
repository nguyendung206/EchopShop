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
        'start_date',
        'end_date',
        'max_uses',
        'current_uses',
        'limit_uses',
    ];

    protected $casts = [
        'type' => TypeDiscount::class,
    ];
}
