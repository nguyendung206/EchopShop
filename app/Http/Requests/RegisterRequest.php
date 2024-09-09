<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        $rule = [
            'name' => ['required', 'min:3', 'max:100'],
            'phone_number' => ['required', 'numeric', 'digits: 10'],
            'email' => ['required', 'email', 'unique:users,email,'.$this->route('id')],
            'address' => ['required', 'min: 3', 'max: 255'],
            'password' => ['required', 'min:3', 'max:255'],
            'passwordConfirm' => ['required', 'same:password'],
            'province_id' => ['not_in:0'],
            'district_id' => ['not_in:0'],
            'ward_id' => ['not_in:0'],
        ];

        return $rule;
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên người dùng',
            'name.min' => 'Tên phải có ít nhất 3 ký tự',
            'name.max' => 'Tên tối đa là 100 ký tự',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 3 ký tự',
            'password.max' => 'Mật khẩu tối đa là 300 ký tự',
            'passwordConfirm.required' => 'Vui lòng xác nhận mật khẩu',
            'passwordConfirm.same' => 'Mật khẩu xác nhận không trùng khớp',
            'phone_number.required' => 'Vui lòng nhập số diện thoại',
            'phone_number.digits' => 'Số điện thoại phải bao gồm 10 số',
            'phone_number.numeric' => 'Số điện thoại chỉ chứa số',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Vui lòng nhập đúng định dạng email',
            'email.unique' => 'Email này đã tồn tại. Vui lòng chọn email khác',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'province_id.not_in' => 'Vui lòng chọn thành phố',
            'district_id.not_in' => 'Vui lòng chọn quận/huyện',
            'ward_id.not_in' => 'Vui lòng chọn phường/thị xã',
        ];
    }
}
