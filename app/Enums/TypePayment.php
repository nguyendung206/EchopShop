<?php

namespace App\Enums;

enum TypePayment: int
{
    case CARD = 1;
    case DIRECT = 2;

    public function label(): string
    {
        return match ($this) {
            self::CARD => 'Thẻ',
            self::DIRECT => 'Trực tiếp',
        };
    }
}
