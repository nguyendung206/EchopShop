<?php

namespace App\Http\Requests;

use App\Enums\Status;
use App\Enums\TypeDiscount;
use App\Enums\TypeDiscountScope;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'type' => ['required', Rule::in(array_column(TypeDiscount::cases(), 'value'))],
            'value' => 'required|numeric|min:0',
            'maxValue' => 'required|numeric|min:0',
            'startTime' => 'required|date',
            'endTime' => 'required|date|after_or_equal:startTime',
            'maxUses' => 'required|numeric|min:0',
            'limitUses' => 'required|numeric|min:0',
            'status' => ['required', Rule::in(array_column(Status::cases(), 'value'))],
            'scope_type' => 'required|integer',
            'province_id' => [Rule::requiredIf($this->input('scope_type') == TypeDiscountScope::REGIONAL->value), 'nullable', 'integer'],
            'district_id' => 'nullable|integer|different:0',
            'ward' => 'nullable|integer|different:0',
        ];

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->limitUses > $this->maxUses) {
                $validator->errors()->add('limitUses', 'Số lượt dùng của mỗi người phải nhỏ hơn hoặc bằng với số lượng mã');
            }
            if ($this->type != TypeDiscount::PERCENT->value && $this->maxValue < $this->value) {
                $validator->errors()->add('maxValue', 'Số tiền giảm giá tối đa phải lớn hơn số tiền giảm giá');
            }
            if ($this->type == TypeDiscount::PERCENT->value && $this->value > 100) {
                $validator->errors()->add('value', 'Số tiền giảm giá phải bé hơn hoặc bằng 100%');
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
            'province_id' => 'Tỉnh/Thành phố',
        ];
    }
}
