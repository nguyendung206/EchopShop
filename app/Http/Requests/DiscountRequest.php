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
            'photo' => 'file|max:10240',
            'code' => 'required|string|max:50|unique:discounts,code,'.$this->route('discount'),
            'type' => 'required|in:1,2',
            'value' => 'required|numeric|min:0',
            'maxValue' => 'required|numeric|min:0',
            'startTime' => 'required|date',
            'endTime' => 'required|date|after_or_equal:startTime',
            'maxUses' => 'required|numeric|min:0',
            'limitUses' => 'required|numeric|min:0',
            'status' => 'required|in:1,2',
        ];

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->limitUses > $this->maxUses) {
                $validator->errors()->add('limitUses', 'Số lượt dùng của mỗi người phải nhỏ hơn hoặc bằng với số lượng mã');
            }
            if ($this->maxValue < $this->value) {
                $validator->errors()->add('maxValue', 'Số tiền giảm giá tối đa phải lớn hơn số tiền giảm giá');
            }
        });
    }

    public function attributes()
    {
        return [
            'title' => 'Tiêu đề',
            'photo' => 'Ảnh giảm giá',
            'description' => 'Mô tả',
            'code' => 'mã giảm giá',
            'type' => 'Loại giảm giá',
            'value' => 'Số tiền giảm giá',
            'maxValue' => 'Số tiền giảm tối đa',
            'startTime' => 'Ngày bắt đầu',
            'endTime' => 'Ngày kết thúc',
            'maxUses' => 'Số lượng mã giảm giá',
            'limitUses' => 'Giới hạn số lần sử dụng',
            'status' => 'Trạng thái',
        ];
    }
}
