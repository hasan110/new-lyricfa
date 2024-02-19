<?php

use App\Exceptions\Throwable\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

if (!function_exists('validateData')) {
    /**
     * validate request and returns custom response
     * @param Request $request
     * @param array $rules
     * @return array
     * @throws ValidationException
     * @throws \Illuminate\Validation\ValidationException
     */
    function validateData(Request $request, array $rules): array
    {
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            throw (new ValidationException(__('errors.validation_error')))->withErrors($validator->errors());
        }

        return $validator->validated();
    }
}

if (!function_exists('validateMobile')) {
    /**
     * validate and remove additional characters from mobile number
     * @param string $prefix_code
     * @param string $phone_number
     * @return array
     */
    function validateMobile(string $prefix_code, string $phone_number): array
    {
        return [$prefix_code, $phone_number];
    }
}
