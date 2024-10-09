<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitProductUnit extends Model
{
    use HasFactory;

    protected $table = 'wait_product_units';

    public function waitProduct()
    {
        return $this->belongsTo(WaitProduct::class, 'wait_product_id', 'id');
    }
}
