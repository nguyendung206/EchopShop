<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
    {   $rule = [
        'title' => ['required', 'max: 255'],
        'description' => ['required', 'max: 255'],
        'link' => ['required', 'max:255'],
        ];
        return $rule;
    }
    public function attributes() {
        return [
            'title' => 'Tiêu đề',
            'description' => 'Mô tả',
            'link' => 'liên kết',
        ];
    }
}
