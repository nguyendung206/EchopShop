<?php

namespace App\Imports;

use App\Enums\Status;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CategoryImport implements ToModel, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
        Validator::extend('status_valid', function ($attribute, $value, $parameters, $validator) {
            $input = mb_strtolower($value, 'UTF-8');
            $validStatuses = array_map(fn ($status) => mb_strtolower($status->label(), 'UTF-8'), Status::cases());

            return in_array($input, $validStatuses);
        });

        return [
            'ten_danh_muc' => 'required|string|max:255',
            'mo_ta' => 'required|string|max:1000',
            'trang_thai' => ['required', 'status_valid'],
        ];
    }

    public function model(array $row)
    {
        $statusValue = collect(Status::cases())->first(fn ($status) => mb_strtolower($status->label(), 'UTF-8') === mb_strtolower($row['trang_thai'], 'UTF-8'));

        return new Category([
            'name' => $row['ten_danh_muc'],
            'description' => $row['mo_ta'],
            'photo' => $row['anh'],
            'status' => $statusValue,
        ]);
    }

    public function customValidationMessages()
    {
        return [
            'ten_danh_muc.required' => 'Cột tên là bắt buộc.',
            'ten_danh_muc.string' => 'Cột tên phải là chuỗi ký tự.',
            'ten_danh_muc.max' => 'Cột tên không được vượt quá 255 ký tự.',
            'mo_ta.required' => 'Cột mô tả là bắt buộc.',
            'mo_ta.string' => 'Cột mô tả phải là chuỗi ký tự.',
            'mo_ta.max' => 'Cột mô tả không được vượt quá 1000 ký tự.',
            'trang_thai.required' => 'Cột trạng thái là bắt buộc.',
            'trang_thai.status_valid' => ':input Cột trạng thái không hợp lệ, giá trị bắt buộc phải 1 trong các trường hợp "Không hoạt động", "Hoạt động", "Tạm dừng".',
        ];
    }
}
