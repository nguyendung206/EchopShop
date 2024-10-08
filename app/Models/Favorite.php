<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public static function getUserFavoriteCount($userId)
    {
        return self::where('user_id', $userId)->count();
    }
}
