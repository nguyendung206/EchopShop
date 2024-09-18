<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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

        $rule = ['name' => ['required', 'max:255'],
            'status' => ['required', 'in:1,2'],
            'content' => ['required', 'max: 1000'],
            'email' => ['required', 'email'], ];

        if (stripos($this->url(), '/admin/contact/sendMail') !== false && $this->method() == 'POST') {
            $rule = ['content' => 'required', 'max: 1000'];
        }

        return $rule;
    }

    public function attributes()
    {
        return [
            'name' => 'Tên người gửi',
            'content' => 'Nội dung',
            'email' => 'email',
            'status' => 'Trạng thái',
        ];
    }
}
