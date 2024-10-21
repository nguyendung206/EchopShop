<?php

namespace App\Enums;

enum TypeAddress: int
{
    case HOME = 1;
    case OFFICE = 2;

    public function label(): string
    {
        return match ($this) {
            self::HOME => 'Nhà riêng',
            self::OFFICE => 'Văn phòng',
        };
    }
}
