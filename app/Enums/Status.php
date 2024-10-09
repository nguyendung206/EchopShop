<?php

namespace App\Enums;

enum Status: int
{
    case PAUSE = 0;
    case ACTIVE = 1;
    case INACTIVE = 2;

    public function label(): string
    {
        return match ($this) {
            self::PAUSE => 'Tạm dừng',
            self::ACTIVE => 'Hoạt động',
            self::INACTIVE => 'Không hoạt động',
        };
    }
}
