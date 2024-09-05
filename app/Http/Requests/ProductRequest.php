<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'price' => 'required|numeric|min:0',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'list_photo.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'status' => 'required|integer|in:1,2',
            'description' => 'nullable|string',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'colors.*' => 'nullable|string',
            'sizes.*' => 'nullable|string',
            'quantities.*' => 'nullable|integer|min:0',
            'types.*' => 'nullable|string|in:color,size',
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên sản phẩm.',
            'name.string' => 'Tên sản phẩm phải là một chuỗi ký tự.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',

            'price.required' => 'Vui lòng nhập giá sản phẩm.',
            'price.numeric' => 'Giá sản phẩm phải là một số.',
            'price.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0.',

            'photo.image' => 'Ảnh sản phẩm phải là một hình ảnh.',
            'photo.mimes' => 'Ảnh sản phẩm phải có định dạng jpg, jpeg, png, hoặc gif.',
            'photo.max' => 'Ảnh sản phẩm không được vượt quá 2MB.',

            'list_photo.*.image' => 'Mỗi ảnh trong danh sách ảnh phải là một hình ảnh.',
            'list_photo.*.mimes' => 'Mỗi ảnh trong danh sách ảnh phải có định dạng jpg, jpeg, png, hoặc gif.',
            'list_photo.*.max' => 'Mỗi ảnh trong danh sách ảnh không được vượt quá 10MB.',

            'status.required' => 'Vui lòng chọn trạng thái sản phẩm.',
            'status.integer' => 'Trạng thái sản phẩm phải là một số nguyên.',
            'status.in' => 'Trạng thái sản phẩm không hợp lệ.',

            'description.string' => 'Mô tả sản phẩm phải là một chuỗi ký tự.',

            'brand_id.exists' => 'Thương hiệu không tồn tại.',
            'category_id.exists' => 'Loại sản phẩm không tồn tại.',

            'colors.*.string' => 'Mỗi màu sắc phải là một chuỗi ký tự.',
            'sizes.*.string' => 'Mỗi kích thước phải là một chuỗi ký tự.',
            'quantities.*.integer' => 'Số lượng phải là một số nguyên.',
            'quantities.*.min' => 'Số lượng phải lớn hơn hoặc bằng 0.',
            'types.*.string' => 'Loại phải là một chuỗi ký tự.',
            'types.*.in' => 'Loại không hợp lệ.',
        ];
    }
}
