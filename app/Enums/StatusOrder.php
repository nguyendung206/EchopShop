<?php

namespace App\Enums;

enum StatusOrder: int
{
    case PENDING = 1;
    case SHIPPING = 2;
    case COMPLETED = 3;
    case CANCELLED = 4;
    case RETURN = 5;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Đang đợi',
            self::SHIPPING => 'Đang vận chuyển',
            self::COMPLETED => 'Đã hoàn thành',
            self::CANCELLED => 'Đã huỷ',
            self::RETURN => 'Trả hàng/Hoàn tiền',
        };
    }
}
