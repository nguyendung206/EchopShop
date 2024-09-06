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
        'photo' => ['required']
        ];
        $method = $this->method();
        if ($method == 'PUT') {
            $rule['photo'] = [];
        }
        return $rule;
    }
    public function attributes() {
        return [
            'photo' => 'Ảnh hiển thị'
        ];
    }
}
