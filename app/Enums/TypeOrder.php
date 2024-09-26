<?php

namespace App\Enums;

enum TypeOrder: int
{
    case EXCHANGE = 1;
    case SECONDHAND = 2;
    case GIVEAWAY = 3;

    public function label(): string
    {
        return match ($this) {
            self::EXCHANGE => 'Hàng trao đổi',
            self::SECONDHAND => 'Hàng secondhand',
            self::GIVEAWAY => 'Hàng trao tặng',
        };
    }
}
