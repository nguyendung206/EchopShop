<?php

namespace App\Imports;

use App\Enums\Status;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CategoryImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $validHeaders = ['slug', 'name', 'description', 'photo', 'status'];

    protected function isValidHeader(array $row): bool
    {
        return empty(array_diff($this->validHeaders, array_keys($row)));
    }

    public function model(array $row)
    {
        return new Category([
            'slug' => $row['slug'],
            'name' => $row['name'],
            'description' => $row['description'],
            'photo' => $row['photo'],
            'status' => $row['status'],
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'status' => ['required', Rule::in(array_column(Status::cases(), 'value'))],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories'),
            ],
        ];
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
            'status.in' => 'Cột trạng thái không hợp lệ.',
            'slug.unique' => 'Giá trị của cột slug ":input" đã tồn tại.',
            'slug.required' => 'Cột slug là bắt buộc.',
            'slug.string' => 'Cột slug phải là chuỗi ký tự.',
        ];
    }
}
