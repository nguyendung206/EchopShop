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
                // 'password' => ['required', 'min:3', 'max:255'],
                // 'passwordComfirm' => ['required', 'same:password'],
                'phone_number' => ['required', 'numeric','digits: 10'],
                'email' => ['required','email'],
                'citizen_identification_number' => ['required','numeric', 'digits:12'],
                'day_of_issue' => ['required', 'date_format:d/m/Y'],
                'date_of_birth' => ['required', 'date_format:d/m/Y'],
                'address' => ['required', 'min: 3', 'max: 255', function ($attribute, $value, $fail) {
                    // Kiểm tra ký tự đầu tiên có phải là số không
                    $firstTwoChars = substr($value, 0, 1);
                    if (!ctype_digit($firstTwoChars)) {
                        $fail('Địa chỉ phải bắt đầu bằng số nhà.');
                }}],
                'place_of_issue' => ['required', 'min:3', 'max:255'],
        ];
        if ($this->has('password')) {
            $rules['password'] = ['required', 'min:3', 'max:255'];
            $rules['passwordComfirm'] = ['required', 'same:password'];
        }
    
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
            'passwordComfirm.required' => "Vui lòng xác nhận mật khẩu",
            "passwordComfirm.same" => "Mật khẩu xác nhận không trùng khớp",
            "phone_number.required" => "Vui lòng nhập số diện thoại",
            "phone_number.digits" => "Số điện thoại phải bao gồm 10 số",
            "phone_number.numeric" => "Số điện thoại chỉ chứa số",
            "email.required" => "Vui lòng nhập email",
            "email.email" => "Vui lòng nhập đúng định dạng email", 
            'citizen_identification_number.required' => "Vui lòng nhập căn cước công dân",
            'citizen_identification_number.numeric' => "Căn cước công dân chỉ bao gồm số",
            'citizen_identification_number.digits' => "Căn cước công dân bao gồm 12 số",
            "day_of_issue.required" => "Vui lòng nhập ngày cấp",
            "day_of_issue.date_format" => "Vui lòng nhập ngày cấp theo định dạng dd/MM/yyyy. Ví dụ: 01/12/2020",
            "date_of_birth.required" => "Vui lòng nhập ngày sinh",
            "date_of_birth.date_format" => "Vui lòng nhập ngày sinh theo định dạng dd/MM/yyyy. Ví dụ: 01/12/2020",
            'place_of_issue.required' => "Vui lòng nhập nơi cấp căn cước công dân", 
            'place_of_issue.min' => "Vui lòng nhập tối thiểu 3 ký tự",
            'place_of_issue.max' => "Vui lòng nhập tối đa 255 ký tự",
        ];
    }
}


