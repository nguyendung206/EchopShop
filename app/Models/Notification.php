<?php

namespace App\Models;

use App\Enums\TypeNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => TypeNotification::class,
    ];

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'body',
        'product_id',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function getNotificationCount($userId)
    {
        return self::where('user_id', $userId)->where('is_read', false)->count();
    }
}
