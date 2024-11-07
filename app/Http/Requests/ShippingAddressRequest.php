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

    public function messages()
    {
        return [
            'user_name.required' => 'Vui lòng nhập tên người dùng',
            'user_name.min' => 'Tên phải có ít nhất 3 ký tự',
            'user_name.max' => 'Tên tối đa là 100 ký tự',
            'phone.required' => 'Vui lòng nhập số diện thoại',
            'phone.digits' => 'Số điện thoại phải bao gồm 10 số',
            'phone.numeric' => 'Số điện thoại chỉ chứa số',
            'street.required' => 'Vui lòng nhập địa chỉ',
            'province_id.required' => 'Vui lòng chọn thành phố',
            'province_id.not_in' => 'Vui lòng chọn thành phố',
            'district_id.required' => 'Vui lòng chọn quận/huyện',
            'district_id.not_in' => 'Vui lòng chọn quận/huyện',
            'ward_id.required' => 'Vui lòng chọn phường/thị xã',
            'ward_id.not_in' => 'Vui lòng chọn phường/thị xã',
        ];
    }
}
