<?php

namespace App\Enums;

enum TypeProductUnit: int
{
    case ONLYQUANTITY = 1;
    case FULL = 2;

    public function label(): string
    {
        return match ($this) {
            self::ONLYQUANTITY => 'Chỉ có số lượng',
            self::FULL => 'Đầy đủ chi tiết',
        };
    }
}
