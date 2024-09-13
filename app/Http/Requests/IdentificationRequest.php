<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IdentificationRequest extends FormRequest
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
            'citizen_identification_number' => ['required', 'numeric', 'digits:12'],
            'identification_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'place_of_issue' => ['required', 'min:3', 'max:255'],
            'date_of_issue' => ['required'],
            'date_of_birth' => ['required'],
        ];

        return $rule;
    }

    public function attributes()
    {
        return [
            'citizen_identification_number' => 'Căn cước công dân',
            'place_of_issue' => 'Nơi cấp',
            'date_of_issue' => 'Ngày cấp',
            'date_of_birth' => 'Ngày sinh',
        ];
    }
}
