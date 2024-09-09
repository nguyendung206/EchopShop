<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $casts = [
        'status' => Status::class,
    ];
    protected $fillable = [
        'title',
        'description',
        'photo',
        'display_order',
        'status',
        'link'
    ];
}
