<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'email' => 'required|email|unique:admins,email,'.$this->id,
            'uploadPhoto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên thương hiệu',
            'email' => 'Email',
            'uploadPhoto' => 'Ảnh đại diện',
        ];
    }
}
