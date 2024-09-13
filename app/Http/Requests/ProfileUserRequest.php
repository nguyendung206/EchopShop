<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUserRequest extends FormRequest
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
            'phone_number' => ['required', 'numeric', 'digits:10'],
            'email' => ['required', 'email', 'unique:users,email,'.$this->id],
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'address' => ['required', 'min:3', 'max:255'],
            'province_id' => ['not_in:0'],
            'district_id' => ['not_in:0'],
            'ward_id' => ['not_in:0'],
        ];

        return $rule;
    }

    public function attributes()
    {
        return [
            'name' => 'Tên người dùng',
            'email' => 'Địa chỉ email',
            'phone_number' => 'Số điện thoại',
            'province_id' => 'Thành phố',
            'district_id' => 'Quận/huyện',
            'ward_id' => 'Phường/thị xã',
            'address' => 'Địa chỉ chi tiết',
        ];
    }
}
