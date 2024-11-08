<?php

namespace App\Enums;

enum StatusExchange: int
{
    case PENDING = 1;
    case APPROVED = 2;
    case REJECTED = 3;
    case COMPLETED = 4;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Đang đợi',
            self::APPROVED => 'Đã chấp nhận',
            self::REJECTED => 'Đã từ chối',
            self::COMPLETED => 'Đã hoàn thành',
        };
    }
}
