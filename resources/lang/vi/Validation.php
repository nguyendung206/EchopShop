<?php

return [

    'required' => 'Vui lòng nhập :attribute.',
    'string' => ':attribute phải là chuỗi ký tự.',
    'max' => [
        'string' => ':attribute không được vượt quá :max ký tự.',
        'numeric' => ':attribute không được vượt quá :max.',
        'file' => ':attribute không được vượt quá :max kilobytes.',
        'array' => ':attribute không được có quá :max mục.',
    ],
    'min' => [
        'string' => ':attribute phải có ít nhất :min ký tự.',
        'numeric' => ':attribute phải lớn hơn hoặc bằng :min.',
        'file' => ':attribute phải có ít nhất :min kilobytes.',
        'array' => ':attribute phải có ít nhất :min mục.',
    ],
    'numeric' => ':attribute phải là một số.',
    'image' => ':attribute phải là hình ảnh.',
    'mimes' => ':attribute phải có định dạng: :values.',
    'mimetypes' => ':attribute phải có định dạng: :values.',
    'exists' => ':attribute không tồn tại.',
    'in' => ':attribute không hợp lệ.',
    'same' => ':attribute và :other phải trùng khớp.',
    'digits' => ':attribute phải có :digits chữ số.',
    'not_in' => ':attribute không hợp lệ.',
    'unique' => ':attribute đã tồn tại. Vui lòng chọn :attribute khác.',
    'url' => ':attribute không hợp lệ.',
    'date_format' => ':attribute phải phù hợp với định dạng :format.',
    'before_or_equal' => ':attribute phải trước hoặc bằng :date.',
    'after_or_equal' => ':attribute phải sau hoặc bằng :date.',
    'timezone' => ':attribute phải là một múi giờ hợp lệ.',
    'email' => ':attribute phải là một địa chỉ email hợp lệ.',
    'password' => 'Mật khẩu không đúng.',
];
