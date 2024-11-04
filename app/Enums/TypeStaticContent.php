<?php

namespace App\Enums;

enum TypeStaticContent: int
{
    case SELLER_GUIDE = 1;
    case BECOME_SELLER = 2;
    case FAQ = 3;
    case BUYER_PROTECTION_POLICY = 4;
    case FEEDBACK = 5;
    case OPERATION_RULES = 6;
    case DISPUTE_RESOLUTION_POLICY = 7;
    case ABOUT_US = 8;
    case CONTACT_US = 9;
    case BLOG = 10;
    case REGISTER = 11;
    case LOGIN = 12;
    case FAVOURITE = 13;
    case MESSAGE = 14;
    case SECURITY = 15;
    case TERM = 16;
    case PROHIBITED = 17;
    case COMMUNICATE = 18;
    case SAFETOUSE = 19;

    public function label(): string
    {
        return match ($this) {
            self::SELLER_GUIDE => 'Hướng dẫn bán hàng',
            self::BECOME_SELLER => 'Trở thành người bán hàng',
            self::FAQ => 'Câu hỏi thường gặp',
            self::BUYER_PROTECTION_POLICY => 'Chính sách bảo vệ người mua',
            self::FEEDBACK => 'Phản hồi',
            self::OPERATION_RULES => 'Quy chế hoạt động',
            self::DISPUTE_RESOLUTION_POLICY => 'Chính sách giải quyết tranh chấp',
            self::ABOUT_US => 'Giới thiệu',
            self::CONTACT_US => 'Liên hệ với chúng tôi',
            self::BLOG => 'Blog',
            self::REGISTER => 'Đăng ký',
            self::LOGIN => 'Đăng nhập',
            self::FAVOURITE => 'Yêu thích',
            self::MESSAGE => 'Tin nhắn',
            self::SECURITY => 'Chính sách bảo mật',
            self::TERM => 'Điều khoản dịch vụ',
            self::PROHIBITED => 'Hành vi bị cấm',
            self::COMMUNICATE => 'Chính sách giao tiếp',
            self::SAFETOUSE => 'Hướng dẫn an toàn sử dụng',
        };
    }

    public static function isValid($value): bool
    {
        return in_array($value, array_column(self::cases(), 'value'));
    }
}
