<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'hotline' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'open' => 'required|integer|min:0|max:24',
            'close' => 'required|integer|min:0|max:24',
            'address' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên shop',
            'hotline' => 'Số hotline',
            'email' => 'Email',
            'open' => 'Giờ mở cửa',
            'close' => 'Giờ đóng cửa',
            'address' => 'Địa chỉ',
            'logo' => 'Logo',
        ];
    }
}
