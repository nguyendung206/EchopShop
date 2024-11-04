<?php

namespace App\Models;

use App\Enums\Status;
use App\Enums\TypeStaticContent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticContent extends Model
{
    use HasFactory;

    protected $table = 'static_content';

    protected $casts = [
        'status' => Status::class,
        'type' => TypeStaticContent::class,
    ];

    protected $fillable = [
        'description',
        'status',
        'type',
        'title',
    ];
}
