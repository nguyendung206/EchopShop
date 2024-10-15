<?php

namespace App\Http\Requests;

use App\Enums\Status;
use App\Enums\TypeProduct;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'status' => ['required', 'integer', Rule::in(array_column(Status::cases(), 'value'))],
            'type' => ['required', 'integer', Rule::in(array_column(TypeProduct::cases(), 'value'))],
            'description' => 'nullable|string',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'unittype' => 'required|integer|in:1,2',
            'quantity' => 'required_if:unittype,1|nullable|integer|min:1',
            'quantities' => 'required_if:unittype,2',
            'quantities.*' => 'required_if:unittype,2|integer|distinct',
            'colors' => 'required_if:unittype,2|array',
            'colors.*' => 'required_if:unittype,2|string|distinct',
            'sizes' => 'required_if:unittype,2|array',
            'sizes.*' => 'required_if:unittype,2|string|distinct',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if ($this->input('unittype') == 2 && empty($this->input('colors'))) {
                $validator->errors()->add('colors', 'Bạn cần nhập ít nhất một màu sắc khi chọn loại đơn vị là Kích cỡ, màu, số lượng.');
            }

            if ($this->input('unittype') == 2 && empty($this->input('quantities'))) {
                $validator->errors()->add('quantities', 'Bạn cần nhập số lượng cho từng màu sắc khi chọn loại đơn vị là Kích cỡ, màu, số lượng.');
            }
        });
    }

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
            'unittype' => 'Kiểu sản phẩm',
            'quantity' => 'Số lượng',
            'colors.*' => 'Màu sắc',
            'sizes.*' => 'Kích thước',
        ];
    }
}
