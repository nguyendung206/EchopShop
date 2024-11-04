<?php

namespace App\Imports;

use App\Enums\StatusOrder;
use App\Enums\TypePayment;
use App\Models\Discount;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Models\Province;
use App\Models\User;
use App\Models\Ward;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class OrderImport implements ToModel, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
        Validator::extend('status_valid', function ($attribute, $value, $parameters, $validator) {
            $input = mb_strtolower($value, 'UTF-8');
            $validStatuses = array_map(fn ($status) => mb_strtolower($status->label(), 'UTF-8'), StatusOrder::cases());

            return in_array($input, $validStatuses);
        });

        Validator::extend('customer_valid', function ($attribute, $value, $parameters, $validator) {
            $input = mb_strtolower($value, 'UTF-8');
            $users = User::all();
            $validusers = $users->pluck('name')->map(fn ($name) => mb_strtolower($name, 'UTF-8'))->toArray();

            return in_array($input, $validusers);
        });

        Validator::extend('ward_valid', function ($attribute, $value, $parameters, $validator) {
            $input = mb_strtolower($value, 'UTF-8');
            $ward = Ward::whereRaw('LOWER(ward_name) LIKE ?', ['%'.$input.'%'])->first();

            return $ward ? true : false;
        });

        Validator::extend('district_valid', function ($attribute, $value, $parameters, $validator) {
            $input = mb_strtolower($value, 'UTF-8');
            $district = District::whereRaw('LOWER(district_name) LIKE ?', ['%'.$input.'%'])->first();

            return $district ? true : false;
        });

        Validator::extend('province_valid', function ($attribute, $value, $parameters, $validator) {
            $input = mb_strtolower($value, 'UTF-8');
            $province = Province::whereRaw('LOWER(province_name) LIKE ?', ['%'.$input.'%'])->first();

            return $province ? true : false;
        });

        Validator::extend('discount_valid', function ($attribute, $value, $parameters, $validator) {
            $input = mb_strtolower($value, 'UTF-8');
            $discounts = Discount::all();
            $validDiscounts = $discounts->pluck('code')->map(fn ($name) => mb_strtolower($name, 'UTF-8'))->toArray();

            return in_array($input, $validDiscounts);
        });

        return [
            'ten_khach_hang' => 'nullable|string|max:1000|customer_valid',
            'dia_chi_nhan_hang' => 'nullable|string|max:1000',
            'phuong_xa' => 'nullable|string|max:1000|ward_valid',
            'tinh_thanh' => 'nullable|string|max:1000|province_valid',
            'quan_huyen' => 'nullable|string|max:1000|district_valid',
            'tien_goc' => 'nullable|numeric|regex:/^\d{1,7}(\.\d{1,8})?$/',
            'ma_giam_gia' => 'nullable|string|max:100|discount_valid',
            'trang_thai' => ['nullable', 'status_valid'],
        ];
    }

    public function model(array $row)
    {
        $statusValue = collect(StatusOrder::cases())->first(fn ($status) => mb_strtolower($status->label(), 'UTF-8') === mb_strtolower($row['trang_thai'], 'UTF-8'));
        $user = User::where('name', 'LIKE', $row['ten_khach_hang'])->first();
        $discount = Discount::where('code', 'LIKE', $row['ma_giam_gia'])->first();
        if (! empty($row['ma_giam_gia'])) {
            $discount = null;
        }
        $ward = Ward::whereRaw('LOWER(ward_name) LIKE ?', ['%'.$row['phuong_xa'].'%'])->first();
        $district = District::whereRaw('LOWER(district_name) LIKE ?', ['%'.$row['quan_huyen'].'%'])->first();
        $province = Province::whereRaw('LOWER(province_name) LIKE ?', ['%'.$row['tinh_thanh'].'%'])->first();
        $newOrder = collect();
        $orderId = null;
        if (! empty($row['ten_khach_hang'])) {

            $newOrder = new Order([
                'user_id' => $user->id ?? null,
                'total_amount' => $row['tien_goc'],
                'status' => $statusValue,
                'type_payment' => TypePayment::DIRECT->value,
                'shipping_address' => $row['dia_chi_nhan_hang'],
                'discount_id' => $discount->id ?? null,
                'ward_id' => $ward->id ?? null,
                'district_id' => $district->id ?? null,
                'province_id' => $province->id ?? null,
            ]);
            $newOrder->save();
            $orderId = $newOrder->id;
        } else {
            $newOrder = Order::latest()->orderBy('id', 'desc')->first();
            $orderId = $newOrder ? $newOrder->id : null;
        }
        if (array_key_exists('ten_san_pham', $row) || array_key_exists('kich_co', $row) || array_key_exists('mau', $row) || array_key_exists('so_luong', $row)) {
            if ($orderId) {
                $product = Product::where('name', 'LIKE', $row['ten_san_pham'])->first();
                $productUnit = null;
                if (isset($row['kich_co']) || isset($row['mau'])) {
                    $productUnit = ProductUnit::where('color', 'LIKE', $row['mau'])->where('size', 'LIKE', $row['kich_co'])->first();
                } else {
                    $productUnit = ProductUnit::where('product_id', $product->id)->first();
                }
                $orderDetail = new OrderDetail([
                    'order_id' => $orderId,
                    'product_id' => $product->id ?? null,
                    'quantity' => $row['so_luong'],
                    'product_unit_id' => $productUnit->id ?? null,
                ]);
                $orderDetail->save();
            }
        }

        return $newOrder;
    }

    public function customValidationMessages()
    {
        return [
            'ten_khach_hang.string' => 'Cột tên khách hàng là chuỗi ký tự.',
            'ten_khach_hang.max' => 'Cột tên không được vượt quá 1000 ký tự.',
            'ten_khach_hang.customer_valid' => 'Không có khách hàng nào tên :input.',
            'dia_chi_nhan_hang.string' => 'Cột địa chỉ khách hàng là chuỗi ký tự.',
            'dia_chi_nhan_hang.max' => 'Cột địa chỉ không được vượt quá 1000 ký tự.',
            'phuong_xa.string' => 'Cột tên phường xã là chuỗi ký tự.',
            'phuong_xa.max' => 'Cột tên phường xã không được vượt quá 1000 ký tự.',
            'phuong_xa.ward_valid' => 'Không có phường xã tên :input.',
            'tinh_thanh.string' => 'Cột tên tỉnh thành là chuỗi ký tự.',
            'tinh_thanh.max' => 'Cột tên tỉnh thành không được vượt quá 1000 ký tự.',
            'tinh_thanh.province_valid' => 'Không có tỉnh thành tên :input.',
            'quan_huyen.string' => 'Cột tên quận huyện là chuỗi ký tự.',
            'quan_huyen.max' => 'Cột tên quận huyện không được vượt quá 1000 ký tự.',
            'quan_huyen.district_valid' => 'Không có quận huyện tên :input.',
            'tien_goc.numeric' => 'Tiền gốc chỉ chứa số không chứa ký tự.',
            'tien_goc.regex' => 'Tiền gốc không hợp lệ',
            'ma_giam_gia.discount_valid' => 'Mã giảm giá không tồn tại',
            'trang_thai.status_valid' => 'Trạng thái không hợp lệ',
        ];
    }
}
