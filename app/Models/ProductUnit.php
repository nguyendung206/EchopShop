<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    use HasFactory;
    protected $table = 'product_units';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
