<?php
$rules = [

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

    'accepted' => ':attribute يجب الموافقه عليه.',
    'active_url' => ':attribute ليس رابط صحيح.',
    'after' => ':attribute must be a date after :date.',
    'after_or_equal' => ':attribute يجب ان يكون بعد او مساوى :date.',
    'alpha' => ':attribute must only contain letters.',
    'alpha_dash' => ':attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => ':attribute must only contain letters and numbers.',
    'array' => ':attribute يجب ان يكون مجموعه.',
    'before' => ':attribute must be a date before :date.',
    'before_or_equal' => ':attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => ':attribute must be between :min and :max.',
        'file' => ':attribute must be between :min and :max kilobytes.',
        'string' => ':attribute must be between :min and :max characters.',
        'array' => ':attribute must have between :min and :max items.',
    ],
    'boolean' => ':attribute field must be true or false.',
    'confirmed' => ':attribute غير متطابقتين.',
    'date' => ':attribute ليس تاريخ.',
    'date_equals' => ':attribute يجب ان يكون مساوى :date.',
    'date_format' => ':attribute does not match the format :format.',
    'different' => ':attribute and :other must be different.',
    'digits' => ':attribute يجب ان يكون :digits رمز.',
    'digits_between' => ':attribute must be between :min and :max digits.',
    'dimensions' => ':attribute has invalid image dimensions.',
    'distinct' => ':attribute field has a duplicate value.',
    'email' => ':attribute يجب ان يكون ايميل.',
    'ends_with' => ':attribute must end with one of the following: :values.',
    'exists' => 'الاختيار :attribute يجب غير صحيح.',
    'file' => ':attribute يجب ان يكون ملف.',
    'filled' => ':attribute field must have a value.',
    'gt' => [
        'numeric' => ':attribute must be greater than :value.',
        'file' => ':attribute must be greater than :value kilobytes.',
        'string' => ':attribute must be greater than :value characters.',
        'array' => ':attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => ':attribute must be greater than or equal :value.',
        'file' => ':attribute must be greater than or equal :value kilobytes.',
        'string' => ':attribute must be greater than or equal :value characters.',
        'array' => ':attribute must have :value items or more.',
    ],
    'image' => ':attribute يجب ان تكون صوره.',
    'in' => 'المدخل :attribute غير صحيح.',
    'in_array' => ':attribute ليس موجود فى المجموعه :other.',
    'integer' => ':attribute يجب ان يكون رقم.',
    'ip' => ':attribute must be a valid IP address.',
    'ipv4' => ':attribute must be a valid IPv4 address.',
    'ipv6' => ':attribute must be a valid IPv6 address.',
    'json' => ':attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => ':attribute must be less than :value.',
        'file' => ':attribute must be less than :value kilobytes.',
        'string' => ':attribute must be less than :value characters.',
        'array' => ':attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => ':attribute must be less than or equal :value.',
        'file' => ':attribute must be less than or equal :value kilobytes.',
        'string' => ':attribute must be less than or equal :value characters.',
        'array' => ':attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => ':attribute must not be greater than :max.',
        'file' => ':attribute يجب ان يكون اصغر من :max kilobytes.',
        'string' => ':attribute must not be greater than :max characters.',
        'array' => ':attribute must not have more than :max items.',
    ],
    'mimes' => ':attribute يجب ان يكون type: :values.',
    'mimetypes' => ':attribute must be a file of type: :values.',
    'min' => [
        'numeric' => ':attribute يجب ان يكون اكثر من :min.',
        'file' => ':attribute يجب ان يكون اكبر من :min kilobytes.',
        'string' => ':attribute يجب ان يكون اكثر من :min حروف.',
        'array' => ':attribute must have at least :min items.',
    ],
    'multiple_of' => ':attribute must be a multiple of :value.',
    'not_in' => 'selected :attribute is invalid.',
    'not_regex' => ':attribute format is invalid.',
    'numeric' => ':attribute يجب ان يكون رقم.',
    'password' => 'الكلمه السر مش صحيحه.',
    'present' => ':attribute field must be present.',
    'regex' => ':attribute format is invalid.',
    'required' => ' يجب ادخال :attribute',
    'required_if' => ' يجب ادخال :attribute',
    'required_unless' => ':attribute field is required unless :other is in :values.',
    'required_with' => ':attribute field is required when :values is present.',
    'required_with_all' => ':attribute field is required when :values are present.',
    'required_without' => ':attribute field is required when :values is not present.',
    'required_without_all' => ':attribute field is required when none of :values are present.',
    'prohibited_if' => ':attribute field is prohibited when :other is :value.',
    'prohibited_unless' => ':attribute field is prohibited unless :other is in :values.',
    'same' => ':attribute and :other must match.',
    'size' => [
        'numeric' => ':attribute must be :size.',
        'file' => ':attribute must be :size kilobytes.',
        'string' => ':attribute must be :size characters.',
        'array' => ':attribute must contain :size items.',
    ],
    'starts_with' => ':attribute must start with one of the following: :values.',
    'string' => ':attribute يجب ان يكون نص.',
    'timezone' => ':attribute must be a valid zone.',
    'unique' => ':attribute تم استعماله من قبل.',
    'uploaded' => ':attribute failed to upload.',
    'url' => ':attribute format is invalid.',
    'uuid' => ':attribute must be a valid UUID.',
    'skill_validation' => "يجب ان تكون اكثر من :count",
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
    | following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

];

return $rules;
