<?php

namespace App\Imports;

use App\Enums\Status;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'status' => ['required', 'status_valid'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories'),
            ],
        ];
    }

    public function model(array $row)
    {
        $statusValue = collect(Status::cases())->first(fn ($status) => mb_strtolower($status->label(), 'UTF-8') === mb_strtolower($row['status'], 'UTF-8'));

        return new Category([
            'slug' => $row['slug'],
            'name' => $row['name'],
            'description' => $row['description'],
            'photo' => $row['photo'],
            'status' => $statusValue,
        ]);
    }

    public function customValidationMessages()
    {
        return [
            'name.required' => 'Cột tên là bắt buộc.',
            'name.string' => 'Cột tên phải là chuỗi ký tự.',
            'name.max' => 'Cột tên không được vượt quá 255 ký tự.',
            'description.required' => 'Cột mô tả là bắt buộc.',
            'description.string' => 'Cột mô tả phải là chuỗi ký tự.',
            'description.max' => 'Cột mô tả không được vượt quá 1000 ký tự.',
            'status.required' => 'Cột trạng thái là bắt buộc.',
            'status.status_valid' => ':input Cột trạng thái không hợp lệ, giá trị bắt buộc phải 1 trong các trường hợp "Không hoạt động", "Hoạt động", "Tạm dừng".',
            'slug.unique' => 'Giá trị của cột slug ":input" đã tồn tại.',
            'slug.required' => 'Cột slug là bắt buộc.',
            'slug.string' => 'Cột slug phải là chuỗi ký tự.',
        ];
    }
}
