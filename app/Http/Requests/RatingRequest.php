<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
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

    public function rules()
    {
        return [
            'star' => 'required|integer|min:1|max:5',
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'videos.*' => 'nullable|mimes:mp4,avi,mov,wmv|max:20480',
            'content' => 'required|string|max:1000',
            'user_id' => 'exists:users,id',
            'product_id' => 'exists:products,id',
        ];
    }

    public function attributes()
    {
        return [
            'star' => 'Số sao',
            'photo' => 'Ảnh',
            'video' => 'Video',
            'content' => 'Nội dung',
            'user_id' => 'Người dùng',
            'product_id' => 'Sản phẩm',
        ];
    }
}
