<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'status' => 'required|in:1,2',
            'photo' => 'image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên loại hàng',
            'photo' => 'Ảnh loại hàng đại diện',
            'status' => 'Trạng thái loại hàng',
            'description' => 'Mô tả loại hàng',
        ];
    }
}
