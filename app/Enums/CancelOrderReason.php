<?php

namespace App\Enums;

enum CancelOrderReason: int
{
    case CHANGE_ADDRESS = 0;
    case CHANGE_DISCOUNT = 1;
    case CHANGE_PRODUCT = 2;
    case COMPLICATED_PAYMENT = 3;
    case FOUND_BETTER_DEAL = 4;
    case NO_LONGER_NEED = 5;
    case OTHER_REASON = 6;

    public function label(): string
    {
        return match ($this) {
            self::CHANGE_ADDRESS => 'Tôi muốn cập nhật địa chỉ nhận hàng.',
            self::CHANGE_DISCOUNT => 'Tôi muốn thêm/thay đổi mã giảm giá.',
            self::CHANGE_PRODUCT => 'Tôi muốn thay đổi sản phâm (Kích thước, màu sắc, số lượng...).',
            self::COMPLICATED_PAYMENT => 'Thủ tục thanh toán rắc rối.',
            self::FOUND_BETTER_DEAL => 'Tôi tìm thấy chỗ mua tốt hơn (Rẻ hơn, uy tín hơn, giao hàng nhanh hơn).',
            self::NO_LONGER_NEED => 'Tôi không có nhu cầu mua nữa.',
            self::OTHER_REASON => 'Tôi không tìm thấy lý do huỷ phù hợp',
        };
    }
}
