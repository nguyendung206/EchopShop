<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PartnerRequest extends FormRequest
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
            'company_name' => ['required', 'max: 255'],
            'phone_number' => ['required', 'numeric', 'digits:10'],
            'email' => ['required', 'email', 'unique:partners,email,'.$this->route('partner')],
            'photo' => ['file', 'max:10240'],
            'status' => ['required', Rule::in(array_column(Status::cases(), 'value'))],
        ];
    }

    public function attributes()
    {
        return [
            'company_name' => 'Tên công ty',
            'email' => 'Địa chỉ email',
            'phone_number' => 'Số điện thoại',
            'photo' => 'Ảnh hiển thị',
            'status' => 'Trạng thái',
        ];
    }
}
