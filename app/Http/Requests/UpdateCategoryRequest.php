<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'Name' => 'required|string|max:255',
            'Email' => 'required|email|unique:admins,email,' . $this->id,
            'uploadPhoto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'Name.required' => 'Tên là bắt buộc.',
            'Email.required' => 'Email là bắt buộc.',
            'Email.email' => 'Email không hợp lệ.',
            'Email.unique' => 'Email đã tồn tại. Vui lòng chọn email khác.',
            'uploadPhoto.image' => 'Tệp tải lên phải là một hình ảnh.',
            'uploadPhoto.mimes' => 'Hình ảnh phải có định dạng jpg, jpeg hoặc png.',
            'uploadPhoto.max' => 'Hình ảnh tải lên không được lớn hơn 2MB.',
        ];
    }
}
