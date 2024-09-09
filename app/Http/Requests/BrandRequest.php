<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'status' => ['required', Rule::in([Status::ACTIVE->value, Status::INACTIVE->value])], 
            'photo' => 'image|mimes:jpg,jpeg,png|max:2048',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên thương hiệu',
            'photo' => 'Ảnh thương hiệu đại diện',
            'status' => 'Trạng thái thương hiệu',
            'description' => 'Mô tả thương hiệu',
            'category_id' => 'Loại hàng',
        ];
    }
}
