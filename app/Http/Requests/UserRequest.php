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
                'phone_number' => ['required', 'numeric','digits: 10'],
                'email' => ['required','email','unique:users,email,' . $this->route('id'),],
                'citizen_identification_number' => ['required','numeric', 'digits:12'],
                'address' => ['required', 'min: 3', 'max: 255'],
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

    public function messages() {
        return [
            'name.required' => "Vui lòng nhập tên người dùng",
            'name.min' => "Tên phải có ít nhất 3 ký tự",
            'name.max' => "Tên tối đa là 100 ký tự",
            'password.required' => "Vui lòng nhập mật khẩu",
            'password.min' => "Mật khẩu phải có ít nhất 3 ký tự",
            'password.max' => "Mật khẩu tối đa là 300 ký tự",
            'passwordConfirm.required' => "Vui lòng xác nhận mật khẩu",
            "passwordConfirm.same" => "Mật khẩu xác nhận không trùng khớp",
            "phone_number.required" => "Vui lòng nhập số diện thoại",
            "phone_number.digits" => "Số điện thoại phải bao gồm 10 số",
            "phone_number.numeric" => "Số điện thoại chỉ chứa số",
            "email.required" => "Vui lòng nhập email",
            "email.email" => "Vui lòng nhập đúng định dạng email", 
            'citizen_identification_number.required' => "Vui lòng nhập căn cước công dân",
            'citizen_identification_number.numeric' => "Căn cước công dân chỉ bao gồm số",
            'citizen_identification_number.digits' => "Căn cước công dân bao gồm 12 số",
            'place_of_issue.required' => "Vui lòng nhập nơi cấp căn cước công dân", 
            'place_of_issue.min' => "Vui lòng nhập tối thiểu 3 ký tự",
            'place_of_issue.max' => "Vui lòng nhập tối đa 255 ký tự",
            'date_of_issue' => 'Vui lòng chọn ngày cấp',
            'date_of_birth' => 'Vui lòng chọn ngày sinh',
            'email.unique' => 'Email này đã tồn tại. Vui lòng chọn email khác',
            'province_id.not_in' => "Vui lòng chọn thành phố",
            'district_id.not_in' => "Vui lòng chọn quận/huyện",
            'ward_id.not_in' => "Vui lòng chọn phường/thị xã",
        ];
    }
}


