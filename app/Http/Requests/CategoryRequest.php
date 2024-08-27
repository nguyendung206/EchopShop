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

    public function messages()
    {
        return [
            'name.required' => 'Tên loại hàng là bắt buộc.',
            'name.string' => 'Tên loại hàng phải là chuỗi ký tự.',
            'name.max' => 'Tên loại hàng không được vượt quá 255 ký tự.',
            'description.required' => 'Mô tả loại hàng là bắt buộc.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'photo.image' => 'Tệp tải lên phải là hình ảnh.',
            'photo.mimes' => 'Hình ảnh phải có định dạng jpg, jpeg hoặc png.',
            'photo.max' => 'Hình ảnh không được lớn hơn 2MB.',
        ];
    }
}
