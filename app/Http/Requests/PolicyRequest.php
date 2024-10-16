<?php

namespace App\Http\Requests;

use App\Enums\TypePolicy;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PolicyRequest extends FormRequest
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
            'description' => ['required', 'max: 1000'],
            'type' => ['required', 'integer', Rule::in(array_column(TypePolicy::cases(), 'value'))],
        ];
    }

    public function attributes()
    {
        return [
            'description' => 'Mô tả',
            'type' => 'Kiểu chính sách',
        ];
    }
}
