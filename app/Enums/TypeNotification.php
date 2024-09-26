<?php

namespace App\Enums;

enum TypeNotification: int
{
    case ACTIVE = 1;
    case INACTIVE = 2;

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Kích hoạt sản phẩm',
            self::INACTIVE => 'Vô hiệu hóa sản phẩm',
        };
    }
}
