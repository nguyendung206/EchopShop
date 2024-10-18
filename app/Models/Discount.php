<?php

namespace App\Models;

use App\Enums\Status;
use App\Enums\TypeDiscount;
use App\Enums\TypeDiscountScope;
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
        'user_used',
        'scope_type',
        'province_id',
        'district_id',
        'ward_id',
    ];

    protected $casts = [
        'type' => TypeDiscount::class,
        'status' => Status::class,
        'scope_type' => TypeDiscountScope::class,
    ];

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
