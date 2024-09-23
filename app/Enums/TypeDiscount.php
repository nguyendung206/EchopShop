<?php

namespace App\Enums;

enum TypeDiscount: int
{
    case PERCENT = 1;
    case FIXED = 2;

    public function label(): string
    {
        return match ($this) {
            self::PERCENT => 'Phần trăm',
            self::FIXED => 'Số tiền',
        };
    }
}
