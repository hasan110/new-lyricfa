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

    'accepted' => ':attribute باید تایید شود.',
    'accepted_if' => 'فیلد :attribute باید تایید شود زمانی که :other , :value. باشد',
    'active_url' => ':attribute لینک وارد شده معتبر نیست.',
    'after' => ':attribute تاریخ باید بعد از :date باشد',
    'after_or_equal' => ':attribute تاریخ باید بعد یا مساوی با :date باشد.',
    'alpha' => ':attribute فقط حروف مجاز است.',
    'alpha_dash' => ':attribute فقط حروف ، اعداد ، خط تیره مانند - و _ مجاز است',
    'alpha_num' => ':attribute فقط حروف و اعداد مجاز است..',
    'array' => ':attribute فقط آرایه مجاز است.',
    'ascii' => 'فیلد :attribute باید اسکی کد باشد.',
    'before' => ':attribute باید تاریخ قبل از :date باشد.',
    'before_or_equal' => ':attribute باید تاریخ قبل یا مساوی با :date باشد',
    'between' => [
        'array' => ':attribute باید مابین :min و :max آیتم باشد.',
        'file' => ':attribute باید مابین :min و :max کیلوبایت باشد.',
        'numeric' => ':attribute باید مابین  :min و :max باشد',
        'string' => ':attribute باید مابین :min و :max کاراکتر باشد.',
    ],
    'boolean' => ':attribute فیلد باید true یا false باشد.',
    'can' => 'فیلد :attribute شامل مقادیر احراز نشده است.',
    'confirmed' => ':attribute فیلد تایید یکسان نیست.',
    'current_password' => 'رمز عبور صحیح نیست.',
    'date' => ':attribute تاریخ معتبر وارد نشده است.',
    'date_equals' => ':attribute باید تاریخ یکسان با :date وارد شود',
    'date_format' => ':attribute فرمت باید به شکل :format وارد شود',
    'decimal' => 'فیلد :attribute باید :decimal اعشار داشته باشد.',
    'declined' => 'فیلد :attribute باید رد شود.',
    'declined_if' => 'فیلد :attribute باید رد شود زمانی که :other , :value باشد.',
    'different' => 'مقدار :attribute و :other باید متفاوت باشند.',
    'digits' => ':attribute باید :digits رقم باشد.',
    'digits_between' => ':attribute باید مابین :min و :max رقم باشد.',
    'dimensions' => ':attribute طول و عرض تصویر معتبر نیست.',
    'distinct' => ':attribute دارای مقدار تکراری است.',
    'doesnt_end_with' => 'فیلد :attribute نباید با موارد زیر تمام شود : :values.',
    'doesnt_start_with' => 'فیلد :attribute نباید با موارد زیر شروع شود: :values.',
    'email' => ':attribute  معتبر نیست.',
    'ends_with' => ':attribute آخرین مقدار باید شامل این موارد باشد: :values',
    'enum' => ':attribute برای این فیلد نامعتبر است.',
    'exists' => ':attribute مورد انتخاب شده معتبر نیست.',
    'file' => ':attribute باید یک فایل انتخاب شود.',
    'filled' => ':attribute باید یک مقدار وارد شود.',
    'gt' => [
        'array' => ':attribute باید بیشتر از :value آیتم باشد.',
        'file' => ':attribute باید بزرگتر از  :value کیلوبایت باشد.',
        'numeric' => ':attribute باید بزرگتر از :value باشد',
        'string' => ':attribute باید بیشتر از :value کاراکتر باشد.',
    ],
    'gte' => [
        'array' => ':attribute باید حداقل :value آیتم یا بیشتر باشد.',
        'numeric' => ':attribute باید بزگتر یا مساوی با :value باشد',
        'file' => ':attribute باید بزرگتر یا مساوی با :value کیلوبایت باشد.',
        'string' => ':attribute باید بیشتر یا مساوی با :value کاراکتر باشد.',
    ],
    'image' => ':attribute باید یک تصویر انتخاب شود.',
    'in' => ':attribute معتبر نیست.',
    'in_array' => ':attribute فیلد در :other موجود نیست',
    'integer' => ':attribute باید عدد وارد شود.',
    'ip' => ':attribute باید IP آدرس معتبر وارد شود.',
    'ipv4' => ':attribute باید IP آدرس وارد شده IPv4 باشد.',
    'ipv6' => ':attribute باید IP آدرس وارد شده IPv6 باشد.',
    'json' => ':attribute باید مقدار وارد شده JSON باشد.',
    'lowercase' => 'فیلد :attribute باید  باشد lowercase.',
    'lt' => [
        'array' => ':attribute باید کمتر از  :value آیتم باشد.',
        'file' => ':attribute باید کمتر از :value کیلوبایت باشد.',
        'numeric' => ':attribute باید کمتر از :value وارد شود',
        'string' => ':attribute باید کمتر از :value کارکتر باشد.',
    ],
    'lte' => [
        'array' => ':attribute باید کمتر یا مساوی با :value آیتم باشد.',
        'file' => ':attribute باید کمتر یا مساوی با :value کیلوبایت باشد.',
        'numeric' => ':attribute باید کمتر یا مساوی با :value باشد',
        'string' => ':attribute باید کمتر یا مساوی با :value کارکتر باشد.',
    ],
    'mac_address' => 'فیلد :attribute باید یک مک آدرس معتبر باشد.',
    'max' => [
        'array' => ':attribute نباید بیشتر از :max آیتم باشد.',
        'file' => ':attribute نباید بزگتر از :max کیلوبایت باشد.',
        'numeric' => ':attribute نباید بزگتر از :max باشد',
        'string' => ':attribute نباید بیشتر از :max کارکتر باشد.',
    ],
    'max_digits' => 'فیلد :attribute نباید بیشتر از :max حرف باشد.',
    'mimes' => 'پسوند :attribute  باید از موارد زیر باشد : :values ',
    'mimetypes' => ':attribute پسوند و نوع فایل باید: :values باشد',
    'min' => [
        'array' => ':attribute حداقل باید :min آیتم باشد.',
        'file' => ':attribute حداقل باید :min کیلوبایت باشد.',
        'numeric' => ':attribute حداقل باید :min باشد',
        'string' => ':attribute حداقل باید :min کارکتر باشد.',
    ],
    'not_in' => ':attribute معتبر نیست.',
    'not_regex' => ':attribute فرمت وارد شده معتبر نیست.',
    'numeric' => ':attribute باید یک عدد باشد.',
    'present' => ':attribute باید موجودیت داشته باشد.',
    'regex' => ':attribute فرمت قابل قبول نیست.',
    'required' => 'فیلد :attribute اجباری است.',
    'required_if' => 'فیلد :attribute اجباری است در صورتی که :other برابر با :value باشد',
    'required_unless' => 'فیلد :attribute اجباری است مگر اینکه :other برابر با :values باشد',
    'required_with' => 'فیلد :attribute اجباری است وقتی که :values موجود باشد.',
    'required_with_all' => 'فیلد :attribute اجباری است اگر :values موجود باشد.',
    'required_without' => 'فیلد :attribute اجباری است وقتی که :values موجود نباشد.',
    'required_without_all' => 'فیلد :attribute اجباری است اگر هیچ یک از :values موجود نباشد.',
    'same' => ':attribute و :other باید یکسان باشند.',
    'size' => [
        'numeric' => ':attribute باید :size باشد',
        'file' => ':attribute باید :size کیلوبایت باشد.',
        'string' => ':attribute باید :size کاراکتر باشد.',
        'array' => ':attribute باید شامل :size آیتم باشد.',
    ],
    'starts_with' => ':attribute باید با یکی از این موارد آغاز شده باشد: :values',
    'string' => ':attribute باید حروف باشد.',
    'timezone' => ':attribute زمان باید معتبر باشد.',
    'unique' => ':attribute وارد شده قبلا ثبت شده و تکراری است.',
    'uploaded' => ':attribute آپلود دچار اشکال شده است.',
    'url' => ':attribute فرمت قابل قبول نمیباشد.',
    'uuid' => ':attribute باید مقدار UUID معتبر باشد',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        "name" => "نام",
        "username" => "نام کاربری",
        "email" => "آدرس ایمیل",
        "first_name" => "نام",
        "last_name" => "نام خانوادگی",
        "parent_name" => "نام پدر",
        "family" => "نام خانوادگی",
        "password" => "رمز عبور",
        "password_confirmation" => "تاییدیه ی رمز عبور",
        "city" => "شهر",
        "province" => "استان",
        "country" => "کشور",
        "address" => "نشانی",
        "phone" => "تلفن",
        "mobile" => "تلفن همراه",
        "phone_number" => "شماره تلفن",
        "mobile_number" => "تلفن همراه",
        "age" => "سن",
        "sex" => "جنسیت",
        "gender" => "جنسیت",
        "day" => "روز",
        "month" => "ماه",
        "year" => "سال",
        "hour" => "ساعت",
        "minute" => "دقیقه",
        "second" => "ثانیه",
        "title" => "عنوان",
        "text" => "متن",
        "content" => "محتوا",
        "description" => "توضیحات",
        "excerpt" => "گلچین کردن",
        "date" => "تاریخ",
        "time" => "زمان",
        "available" => "موجود",
        "not_available" => "موجود نیست",
        "size" => "اندازه",
        "new_password" => "رمز عبور جدید",
        "current_password" => "رمز عبور فعلی",
        "auth_type" => "نوع احرازهویت",
        "fcm_token" => "توکن",
        "music_id" => "شناسه موزیک",
        "search" => "عبارت جست و چو",
        "search_text" => "عبارت جست و چو",
        "degree" => "درجه",
        "music_video" => "موزیک ویدیو",
        "is_user_request" => "درخواستی کاربر",
        "album_id" => "شناسه آلبوم",
        "with_text" => "با متن",
        "singer_id" => "شناسه خواننده",
        "limit" => "محدودیت",
        "random" => "تصادفی",
        "page" => "صفحه",
        "per_page" => "تعداد در صفحه",
        "order_by" => "مرتب سازی بر اساس",
        "sort_by" => "نزولی صعودی",
        "area_code" => "پیش شماره",
        "commentable_id" => "شناسه مورد دیدگاه",
        "comment" => "دیدگاه",
    ],

];
