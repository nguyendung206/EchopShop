<?php

namespace App\Http\Requests;

use App\Enums\TypeStaticContent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StaticContentRequest extends FormRequest
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
        $rules = [
            'description' => ['required', 'max: 1000'],
            'type' => ['required', 'integer', Rule::in(array_column(TypeStaticContent::cases(), 'value'))],
        ];
        if ($this->input('type') == TypeStaticContent::FAQ->value) {
            $rules['title'] = ['required', 'string', 'max: 200'];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'description' => 'Mô tả',
            'type' => 'Kiểu chính sách',
            'title' => 'tiêu đề',
        ];
    }
}
