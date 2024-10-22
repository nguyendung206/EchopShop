<?php

namespace App\Models;

use App\Enums\TypeAddress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'phone',
        'user_id',
        'street',
        'province_id',
        'district_id',
        'ward_id',
        'type_address',
        'is_default',
    ];

    protected $casts = [
        'type_address' => TypeAddress::class,
    ];

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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
