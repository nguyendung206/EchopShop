<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;
    protected $casts = [
        'status' => Status::class,
    ];
    protected $fillable = [
        'description',
        'status',
    ];
}
