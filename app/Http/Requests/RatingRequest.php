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

    /**
     * Rules for validating the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'star' => 'required|integer|min:1|max:5',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:10240',
            'videos' => 'nullable|array',
            'videos.*' => 'nullable|mimetypes:video/mp4,video/avi,video/mov,video/wmv|max:20480',
            'content' => 'required|string|max:1000',
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ];
    }

    public function attributes()
    {
        return [
            'star' => 'Số sao',
            'photos' => 'Ảnh',
            'photos.*' => 'Ảnh',
            'videos' => 'Video',
            'videos.*' => 'Video',
            'content' => 'Nội dung',
            'user_id' => 'Người dùng',
            'product_id' => 'Sản phẩm',
        ];
    }
}
