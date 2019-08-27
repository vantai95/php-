<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute phải được chấp nhận.',
    'active_url' => ':attribute URL không hợp lệ.',
    'after' => ':attribute phải là ngày sau ngày :date.',
    'after_or_equal' => ':attribute phải là ngày sau hoặc bằng :date.',
    'alpha' => ':attribute chỉ có thể chứa kí tự.',
    'alpha_dash' => ':attribute chỉ có thể chứa kí tự, số và dấu gạch ngang.',
    'alpha_num' => ':attribute chỉ có thể chứa kí tự và số.',
    'array' => ':attribute phải là một mảng.',
    'before' => ':attribute phải là ngày trước ngày :date.',
    'before_or_equal' => ':attribute phải là ngày trước hoặc bằng :date.',
    'between' => [
        'numeric' => ':attribute phải từ :min đến :max.',
        'file' => ':attribute phải từ :min đến :max kilobytes.',
        'string' => ':attribute phải từ :min đến :max kí tự.',
        'array' => ':attribute phải có từ :min đến :max items.',
    ],
    'boolean' => ':attribute phải đúng hoặc sai.',
    'confirmed' => 'Xác nhận :attribute không đúng.',
    'date' => ':attribute không phải ngày hợp lệ.',
    'date_format' => ':attribute không khớp với định dạng :format.',
    'different' => ':attribute và :other phải khác nhau.',
    'digits' => ':attribute phải là :digits chữ số.',
    'digits_between' => ':attribute phải nằm trong khoảng từ :min đến :max chứ số.',
    'dimensions' => ':attribute có kích thước hình ảnh không hợp lệ.',
    'distinct' => ':attribute có giá trị trùng lặp.',
    'email' => ' :attribute sai định dạng.',
    'exists' => ':attribute đã chọn không hợp lệ.',
    'file' => ':attribute phải là tệp.',
    'filled' => ':attribute phải có giá trị.',
    'image' => ':attribute phải là một hình ảnh.',
    'in' => ':attribute đã chọn không hợp lệ.',
    'in_array' => ':attribute không tồn tại trong :other.',
    'integer' => ':attribute phải là số nguyên.',
    'ip' => ':attribute phải là địa chỉ IP hợp lệ.',
    'ipv4' => ':attribute phải là địa chỉ IPv4 hợp lệ.',
    'ipv6' => ':attribute phải là địa chỉ IPv6 hợp lệ.',
    'json' => ':attribute phải là một chuỗi JSON hợp lệ.',
    'max' => [
        'numeric' => ':attribute có thể không lớn hơn :max.',
        'file' => ':attribute có thể không lớn hơn :max kilobytes.',
        'string' => 'The :attribute có thể không lớn hơn :max kí tự.',
        'array' => ':attribute có thể không có nhiều hơn :max.',
    ],
    'mimes' => ':attribute phải là một loại tệp: :values.',
    'mimetypes' => ':attribute phải là một loại tệp: :values.',
    'min' => [
        'numeric' => ':attribute phải ít nhất :min.',
        'file' => ':attribute phải ít nhất :min kilobytes.',
        'string' => ':attribute phải ít nhất :min kí tự.',
        'array' => ':attribute phải có ít nhất :min.',
    ],
    'not_in' => ' :attribute không hợp lệ.',
    'numeric' => ':attribute phải là số.',
    'present' => ':attribute không được để trống.',
    'regex' => 'Định dạng :attribute không hợp lệ.',
    'required' => ':attribute là bắt buộc.',
    'required_if' => ':attribute được yêu cầu khi :other có :value.',
    'required_unless' => ':attribute được yêu cầu trừ khi :other trong :values.',
    'required_with' => ':attribute bắt buộc khi có :values.',
    'required_with_all' => ':attribute được yêu cầu khi có :values.',
    'required_without' => ':attribute được yêu cầu khi không có :values.',
    'required_without_all' => ':attribute bắt buộc khi không có :values.',
    'same' => ':attribute và :other phải giống nhau.',
    'size' => [
        'numeric' => ':attribute phải là :size.',
        'file' => ':attribute phải là :size kilobytes.',
        'string' => ':attribute phải là :size kí tự.',
        'array' => ':attribute phải chứa :size.',
    ],
    'string' => ':attribute không hợp lệ.',
    'timezone' => ':attribute phà là vùng hợp lệ.',
    'unique' => ':attribute đã được sử dụng.',
    'uploaded' => ':attribute không thể tải lên.',
    'url' => ':attribute không hợp lệ.',
    'html_required' => ':attribute là bắt buộc.',

    'max_mb' => ':attribute không được quá :max_mb MB.',
    'old_password' => 'Mật khẩu hiện tại không chính xác',
    'recaptcha' => 'Biểu mẫu đăng kí không dành cho rô bốt',
    'is_duplicated' => ':attribute không được trùng',
    'at_least_one' => 'Số lượng :attribute phải có ít nhất một',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'password' => 'mật khẩu',
        'sub_items' => 'món ăn phụ',
        'from_date' => 'Ngày bắt đầu',
        'to_date' => 'Ngày kết thúc',
        'quantity' => 'Món ăn'
    ],

];
