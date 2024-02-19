<?php

return [
    'base_url'=>env('KAVENEGAR_BASE_URL' , 'https://api.kavenegar.com/v1/'),
    'lookup_url'=>env('KAVENEGAR_LOOKUP_URL' , '/verify/lookup.json'),
    'api_key'=>env('KAVENEGAR_API_KEY')
];
