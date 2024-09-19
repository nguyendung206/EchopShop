<?php

namespace App\Models;

use App\Enums\Status;
use App\Enums\TypePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;

    protected $table = 'policies';

    protected $casts = [
        'status' => Status::class,
        'type' => TypePolicy::class,
    ];

    protected $fillable = [
        'description',
        'status',
        'type',
    ];
}
