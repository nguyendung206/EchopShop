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
            'type' => 'required|integer|in:1,2,3',
            'description' => 'nullable|string',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'colors.*' => 'nullable|string',
            'sizes.*' => 'nullable|string',
            'quantities.*' => 'nullable|integer|min:0',
            'unittype' => 'required|integer|in:1,2',
            'quantity' => 'required_if:unittype,1|integer|min:1',
        ];
    }

    /**
     * Get custom attribute names for validation errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Tên sản phẩm',
            'price' => 'Giá sản phẩm',
            'photo' => 'Ảnh sản phẩm chính',
            'list_photo.*' => 'Ảnh sản phẩm khác',
            'status' => 'Trạng thái sản phẩm',
            'type' => 'Kiểu sản phẩm',
            'description' => 'Mô tả sản phẩm',
            'brand_id' => 'Thương hiệu',
            'category_id' => 'Loại sản phẩm',
            'colors.*' => 'Màu sắc',
            'sizes.*' => 'Kích thước',
            'quantities.*' => 'Số lượng',
            'types.*' => 'Loại',
        ];
    }
}
