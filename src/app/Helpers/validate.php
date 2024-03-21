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

if (!function_exists('validate_mobile')) {
    /**
     * validate and remove additional characters from mobile number
     * @param string $area_code
     * @param string $mobile_number
     * @return array
     */
    function validate_mobile(string $area_code, string $mobile_number): array
    {
        return [homogenization($area_code), homogenization($mobile_number)];
    }
}
