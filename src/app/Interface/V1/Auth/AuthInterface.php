<?php

namespace App\Interface\V1\Auth;

interface AuthInterface
{
    /**
     * save activation code in database for validation.
     * @param string $area_code
     * @param string $mobile_number
     * @param int $activate_code
     */
    public function saveActivationCode(string $area_code, string $mobile_number, int $activate_code);

    /**
     * check activation code is valid or not.
     * @param string $area_code
     * @param string $mobile_number
     * @param int $code
     */
    public function checkActivationCode(string $area_code, string $mobile_number, int $code);

    /**
     * if user registered changes token and return user data or register user if not register.
     * @param string $area_code
     * @param string $mobile_number
     * @param string $referral_code
     */
    public function prepareUser(string $area_code, string $mobile_number, string $referral_code);
}
