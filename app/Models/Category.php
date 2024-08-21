<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public function brands()
    {
        return $this->hasMany(Brand::class, 'category_id', 'id');
    }
    public function statusText()
    {
        return $this->status == 1 ? 'Hoạt động' : 'Không hoạt động';
    }
}
