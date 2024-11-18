<?php

namespace App\Http\Requests\Api;

use App\Enums\TypeProduct;
use App\Enums\TypeProductUnit;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
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
            'type' => ['required', 'integer', Rule::in(array_column(TypeProduct::cases(), 'value'))],
            'description' => 'nullable|string',
            'brand_id' => 'nullable|exists:brands,id',
            'category_id' => 'nullable|exists:categories,id',
            'unittype' => ['required', 'integer', Rule::in(array_column(TypeProductUnit::cases(), 'value'))],
            'quantity' => [Rule::requiredIf($this->input('unittype') == TypeProductUnit::ONLYQUANTITY), 'nullable', 'integer', 'min:1'],
            'quantities' => [Rule::requiredIf($this->input('unittype') == TypeProductUnit::FULL)],
            'quantities.*' => [Rule::requiredIf($this->input('unittype') == TypeProductUnit::FULL), 'integer'],
            'colors' => [Rule::requiredIf($this->input('unittype') == TypeProductUnit::FULL), 'nullable', 'array'],
            'colors.*' => [Rule::requiredIf($this->input('unittype') == TypeProductUnit::FULL), 'nullable', 'string'],
            'sizes' => [Rule::requiredIf($this->input('unittype') == TypeProductUnit::FULL), 'nullable', 'array'],
            'sizes.*' => [Rule::requiredIf($this->input('unittype') == TypeProductUnit::FULL), 'nullable', 'string'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (request()->user()->load('shop')->shop === null) {
                $validator->errors()->add('shop', 'Người dùng chưa đăng ký bán hàng.');
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
            'type' => 'Kiểu sản phẩm',
            'description' => 'Mô tả sản phẩm',
            'brand_id' => 'Thương hiệu',
            'category_id' => 'Loại sản phẩm',
            'unittype' => 'Chi tiết sản phẩm',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422));
    }
}
