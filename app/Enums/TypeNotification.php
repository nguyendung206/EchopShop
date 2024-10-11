<?php

namespace App\Enums;

enum TypeNotification: int
{
    case ACTIVE = 1;
    case INACTIVE = 2;
    case REJECT = 3;
    case ACCEPT = 4;
    case CHANGESTATUSORDER = 5;

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Kích hoạt sản phẩm',
            self::INACTIVE => 'Vô hiệu hóa sản phẩm',
            self::REJECT => 'Từ chối cập nhật sản phẩm',
            self::ACCEPT => 'Đã được cập nhật',
            self::CHANGESTATUSORDER => 'Đơn hàng của bạn đã thay đổi trạng thái'
        };
    }
}
