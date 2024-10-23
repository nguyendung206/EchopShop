<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function feeships()
    {
        return $this->hasMany(Feeship::class);
    }
}
