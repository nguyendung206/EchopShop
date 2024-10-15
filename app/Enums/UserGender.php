<?php

namespace App\Enums;

enum UserGender: int
{
    case Male = 0;
    case Female = 1;

    public function label(): string
    {
        return match ($this) {
            self::Male => 'Nam',
            self::Female => 'Nữ',
        };
    }
}
