<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'nullable|string',
            'code' => 'required|string|max:50|unique:discounts,code,'.$this->route('discount'),
            'type' => 'required|in:1,2',
            'value' => 'required|numeric|min:0',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'maxUses' => 'required|numeric|min:0',
            'limitUses' => 'required|numeric|min:0',
        ];

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->limitUses > $this->maxUses) {
                $validator->errors()->add('limitUses', 'Số lượt dùng của mỗi người phải nhỏ hơn hoặc bằng với số lượng mã');
            }
        });
    }

    public function attributes()
    {
        return [
            'title' => 'Tiêu đề',
            'description' => 'Mô tả',
            'code' => 'mã giảm giá',
            'type' => 'Loại giảm giá',
            'value' => 'Số tiền giảm giá',
            'startDate' => 'Ngày bắt đầu',
            'endDate' => 'Ngày kết thúc',
            'maxUses' => 'Số lượng mã giảm giá',
            'limitUses' => 'Giới hạn số lần sử dụng',
        ];
    }
}
