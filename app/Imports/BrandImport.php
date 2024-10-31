<?php

namespace App\Imports;

use App\Enums\Status;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BrandImport implements ToModel, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
        Validator::extend('status_valid', function ($attribute, $value, $parameters, $validator) {
            $input = mb_strtolower($value, 'UTF-8');
            $validStatuses = array_map(fn ($status) => mb_strtolower($status->label(), 'UTF-8'), Status::cases());

            return in_array($input, $validStatuses);
        });

        Validator::extend('category_valid', function ($attribute, $value, $parameters, $validator) {
            $input = mb_strtolower($value, 'UTF-8');
            $categories = Category::all();
            $validCategories = $categories->pluck('name')->map(fn ($name) => mb_strtolower($name, 'UTF-8'))->toArray();

            return in_array($input, $validCategories);
        });

        return [
            'ten_thuong_hieu' => 'required|string|max:255',
            'mo_ta' => 'required|string|max:1000',
            'trang_thai' => ['required', 'status_valid'],
            'ten_danh_muc' => ['required', 'category_valid'],
        ];
    }

    public function model(array $row)
    {
        $statusValue = collect(Status::cases())->first(fn ($status) => mb_strtolower($status->label(), 'UTF-8') === mb_strtolower($row['trang_thai'], 'UTF-8'));
        $category = Category::where('name', 'LIKE', $row['ten_danh_muc'])->first();
        $categoryId = $category ? $category->id : null;

        return new Brand([
            'name' => $row['ten_thuong_hieu'],
            'description' => $row['mo_ta'],
            'photo' => $row['anh'],
            'status' => $statusValue,
            'category_id' => $categoryId,
        ]);
    }

    public function customValidationMessages()
    {
        return [
            'ten_thuong_hieu.required' => 'Cột tên là bắt buộc.',
            'ten_thuong_hieu.string' => 'Cột tên phải là chuỗi ký tự.',
            'ten_thuong_hieu.max' => 'Cột tên không được vượt quá 255 ký tự.',
            'mo_ta.required' => 'Cột mô tả là bắt buộc.',
            'mo_ta.string' => 'Cột mô tả phải là chuỗi ký tự.',
            'mo_ta.max' => 'Cột mô tả không được vượt quá 1000 ký tự.',
            'trang_thai.required' => 'Cột trạng thái là bắt buộc.',
            'trang_thai.status_valid' => ':input Cột trạng thái không hợp lệ, giá trị bắt buộc phải 1 trong các trường hợp "Không hoạt động", "Hoạt động", "Tạm dừng".',
            'ten_danh_muc.category_valid' => ':input Tên danh mục không khớp với bất cứ danh mục nào hiện có.',
        ];
    }
}
