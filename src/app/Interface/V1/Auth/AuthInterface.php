<?php

namespace App\Interface\V1\Auth;

interface AuthInterface
{
    /**
     * according to auth type checks user can continue process or not .
     * @param string $prefix_code
     * @param string $phone_number
     */
    public function checkAuthType(string $prefix_code, string $phone_number);

    /**
     * send sms filled by otp code .
     * @param string $prefix_code
     * @param string $phone_number
     * @param int $activate_code
     */
    public function sendOTP(string $prefix_code, string $phone_number, int $activate_code);

    /**
     * save activation code in database for validation .
     * @param string $prefix_code
     * @param string $phone_number
     * @param string $auth_type
     * @param int $activate_code
     */
    public function saveActivationCode(string $prefix_code, string $phone_number, string $auth_type, int $activate_code);

    /**
     * check activation code is valid or not .
     * @param string $prefix_code
     * @param string $phone_number
     * @param int $code
     */
    public function checkActivationCode(string $prefix_code, string $phone_number, int $code);

    /**
     * if user registered changes token and return user data or register user if not register .
     * @param string $prefix_code
     * @param string $phone_number
     * @param string $referral_code
     */
    public function prepareUser(string $prefix_code, string $phone_number, string $referral_code);
}
