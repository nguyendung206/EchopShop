<?php

namespace App\Enums;

enum StatusOrder: int
{
    case PENDING = 1;
    case TRANSPORTING = 2;
    case SHIPPING = 3;
    case COMPLETED = 4;
    case CANCELLED = 5;
    case RETURN = 6;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Đang đợi',
            self::TRANSPORTING => 'Đang vận chuyển',
            self::SHIPPING => 'Đang giao hàng',
            self::COMPLETED => 'Đã hoàn thành',
            self::CANCELLED => 'Đã huỷ',
            self::RETURN => 'Trả hàng/Hoàn tiền',
        };
    }
}
