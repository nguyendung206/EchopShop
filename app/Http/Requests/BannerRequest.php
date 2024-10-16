<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
    {
        $rule = [
            'title' => ['required', 'max: 255'],
            'description' => ['required', 'max: 255'],
            'link' => ['required', 'max:255'],
            'photo' => ['file', 'max:10240'],
            'status' => ['required', Rule::in(array_column(Status::cases(), 'value'))],
        ];

        return $rule;
    }

    public function attributes()
    {
        return [
            'title' => 'Tiêu đề',
            'description' => 'Mô tả',
            'link' => 'Liên kết',
            'photo' => 'Ảnh hiển thị',
            'status' => 'Trạng thái',
        ];
    }
}
