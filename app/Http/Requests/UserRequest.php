<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                'phone_number' => ['required', 'numeric','digits:10'],
                'email' => ['required','email','unique:users,email,' . $this->id,],
                'citizen_identification_number' => ['required', 'numeric', 'digits:12'],
                'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'identification_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'address' => ['required', 'min:3', 'max:255'],
                'place_of_issue' => ['required', 'min:3', 'max:255'],
                'date_of_issue' => ['required'],
                'date_of_birth' => ['required'],
                'province_id' => ['not_in:0'],
                'district_id' => ['not_in:0'],
                'ward_id' => ['not_in:0'],
        ];
        if ($this->has('password')) {
            $rule['password'] = ['required', 'min:3', 'max:255'];
            $rule['passwordConfirm'] = ['required', 'same:password'];
        }
        $method = $this->method();
        if ($method == 'PUT') {
            $rule['password'] = [];
            $rule['passwordConfirm'] = [];
        }
        // dd($rule);
        return $rule;
    }

    public function attributes() {
        return [
            'name' => 'Tên người dùng',
            'email' => 'Địa chỉ email',
            'password' => 'Mật khẩu',
            'passwordConfirm' => 'Xác nhận mật khẩu',
            'phone_number' => 'Số điện thoại',
            'citizen_identification_number' => 'Căn cước công dân',
            'place_of_issue' => 'Nơi cấp',
            'date_of_issue' => 'Ngày cấp',
            'date_of_birth' => 'Ngày sinh',
            'province_id' => 'Thành phố',
            'district_id' => 'Quận/huyện',
            'ward_id' => 'Phường/thị xã',
            'address' => 'Địa chỉ chi tiết',
        ];
    }
}


