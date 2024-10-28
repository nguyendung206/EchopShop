<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeeshipRequest extends FormRequest
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
            'feename' => 'required|string|max:255',
            'feeship' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'province_id' => 'nullable|exists:provinces,id',
            'district_id' => 'nullable|exists:districts,id',
            'ward_id' => 'nullable|exists:wards,id',
        ];
    }

    public function attributes()
    {
        return [
            'feename' => 'Tên chi phí',
            'feeship' => 'Chi phí vận chuyển',
            'description' => 'Mô tả',
            'province_id' => 'Tỉnh/Thành phố',
            'district_id' => 'Quận/Huyện',
            'ward_id' => 'Phường/Thị xã',
        ];
    }
}
