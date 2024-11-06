<?php

namespace App\Enums;

enum TypeStaticContent: string
{
    case SELLER_GUIDE = 'seller-guide';
    case BECOME_SELLER = 'become-seller';
    case FAQ = 'faq';
    case BUYER_PROTECTION_POLICY = 'buyer-protection-policy';
    case FEEDBACK = 'feedback';
    case OPERATION_RULES = 'operation-rules';
    case DISPUTE_RESOLUTION_POLICY = 'dispute-resolution-policy';
    case ABOUT_US = 'about-us';
    case CONTACT_US = 'contact-us';
    case BLOG = 'blog';
    case REGISTER_CONTENT = 'register-content';
    case LOGIN_CONTENT = 'login-content';
    case FAVOURITE = 'favourite';
    case MESSAGE = 'message';
    case SECURITY = 'security';
    case TERM = 'term';
    case PROHIBITED = 'prohibited';
    case COMMUNICATE = 'communicate';
    case SAFETOUSE = 'safe-to-use';

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
            self::REGISTER_CONTENT => 'Đăng ký',
            self::LOGIN_CONTENT => 'Đăng nhập',
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
