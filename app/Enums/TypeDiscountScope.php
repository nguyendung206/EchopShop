<?php

namespace App\Enums;

enum TypeDiscountScope: int
{
    case GLOBAL = 1;
    case REGIONAL = 2;

    public function label(): string
    {
        return match ($this) {
            self::GLOBAL => 'Mọi nơi',
            self::REGIONAL => 'Khu vực cụ thể',
        };
    }
}
