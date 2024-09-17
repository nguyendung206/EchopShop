<?php

namespace App\Enums;

enum TypePolicy: int
{
    case SECURITY = 1;
    case TERM = 2;
    case PROHIBITED = 3;
    case COMMUNICATE = 4;
    case SAFETOUSE = 5;

    public function label(): string
    {
        return match ($this) {
            self::SECURITY => 'Chính sách bảo mật',
            self::TERM => 'Điều khoản dịch vụ',
            self::PROHIBITED => 'Hành vi bị cấm',
            self::COMMUNICATE => 'Chính sách giao tiếp',
            self::SAFETOUSE => 'Hướng dẫn an toàn sử dụng',
        };
    }
}
