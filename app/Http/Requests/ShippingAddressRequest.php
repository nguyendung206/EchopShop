<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingAddressRequest extends FormRequest
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
            'user_name' => ['required', 'min:3', 'max:100'],
            'phone' => ['required', 'numeric', 'digits: 10'],
            'street' => ['required', 'min: 3', 'max: 255'],
            'province_id' => ['required', 'not_in:0'],
            'district_id' => ['required', 'not_in:0'],
            'ward_id' => ['required', 'not_in:0'],
        ];
    }

    public function attributes()
    {
        return [
            'user_name' => 'Tên người dùng',
            'phone' => 'Số điện thoại',
            'street' => 'Địa chỉ',
            'province_id' => 'Thành phố',
            'district_id' => 'Quận/huyện',
            'ward_id' => 'Phường/thị xã',
        ];
    }
}
