<?php

return [

    'required' => 'Vui lòng nhập :attribute.',
    'string' => ':attribute phải là chuỗi ký tự.',
    'max' => [
        'string' => ':attribute không được vượt quá :max ký tự.',
        'numeric' => ':attribute không được vượt quá :max.',
    ],
    'min' => [
        'string' => ':attribute phải có ít nhất :min ký tự.',
        'numeric' => ':attribute phải lớn hơn hoặc bằng :min.',
    ],
    'numeric' => ':attribute phải là một số.',
    'image' => ':attribute phải là hình ảnh.',
    'mimes' => ':attribute phải có định dạng: :values.',
    'exists' => ':attribute không tồn tại.',
    'in' => ':attribute không hợp lệ.',
    'same' => ':attribute và :other phải trùng khớp.',
    'digits' => ':attribute phải có :digits chữ số.',
    'not_in' => ':attribute không hợp lệ.',
    'unique' => ':attribute đã tồn tại. Vui lòng chọn :attribute khác.',
];
