<?php

namespace App\Repository\V1\Auth;

use App\Interface\V1\Auth\AuthInterface;
use App\Interface\V1\User\UserInterface;
use App\Repository\V1\User\UserRepository;
use App\Models\SmsVerify;
use App\Services\SMS\KaveNegar;
use Carbon\Carbon;
use App\Exceptions\Throwable\BaseException;

class AuthRepository implements AuthInterface
{
    private UserRepository $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * specifies auth type according to user is register or not.
     * @param string $prefix_code
     * @param string $phone_number
     * @return string
     */
    public function checkAuthType(string $prefix_code, string $phone_number): string
    {
        $user = $this->userRepository->getUserByMobile($prefix_code, $phone_number);

        return $user ? "login" : "register";
    }

    /**
     * send sms include otp code.
     * @param string $prefix_code
     * @param string $phone_number
     * @param int $activate_code
     * @return void
     * @throws BaseException
     */
    public function sendOTP(string $prefix_code, string $phone_number, int $activate_code): void
    {
        $receiver = $prefix_code == '98' ? $phone_number : '00'.$prefix_code.$phone_number;
        (new KaveNegar())->sendOtpCode($receiver , $activate_code);
    }

    /**
     * save activation code in database for validation.
     * @param string $prefix_code
     * @param string $phone_number
     * @param string $auth_type
     * @param int $activate_code
     * @return SmsVerify
     */
    public function saveActivationCode(string $prefix_code, string $phone_number, string $auth_type, int $activate_code): SmsVerify
    {
        $sms_verify = new SmsVerify;
        $sms_verify->prefix_code = $prefix_code;
        $sms_verify->phone_number = $phone_number;
        $sms_verify->type = $auth_type;
        if($phone_number == 1234567890 && $auth_type == "login"){
            $sms_verify->code = 1234; //google play account
        }else{
            $sms_verify->code = $activate_code;
        }
        $sms_verify->save();

        return $sms_verify;
    }

    /**
     * check activation code is valid or not.
     * @param string $prefix_code
     * @param string $phone_number
     * @param int $code
     * @return void
     * @throws BaseException
     */
    public function checkActivationCode(string $prefix_code, string $phone_number, int $code): void
    {
        try {
            $sms_verify = SmsVerify::orderBy('id', 'DESC')->where('prefix_code', $prefix_code)->where('phone_number', $phone_number)->first();
            if(!$sms_verify){
                throw new BaseException(__('errors.invalid_phone_number_in_sms_verify'));
            }

            $diff_in_minutes = Carbon::parse($sms_verify->updated_at)->diffInMinutes(Carbon::now());
            if($diff_in_minutes > 10){
                throw new BaseException(__('errors.activation_code_expired'));
            }

            if((int)$sms_verify->code !== $code){
                throw new BaseException(__('errors.activation_code_is_wrong'));
            }
            $sms_verify->delete();
        }catch (BaseException $e){
            throw new BaseException($e->getMessage());
        }
    }

    /**
     * if user registered changes token and return user data or register user if not register.
     * @param string $prefix_code
     * @param string $phone_number
     * @param string|null $referral_code
     * @return string
     * @throws BaseException
     */
    public function prepareUser(string $prefix_code, string $phone_number, string|null $referral_code): string
    {
        try {
            $user = $this->userRepository->getUserByMobile($prefix_code , $phone_number);
            if(!$user) {
                $referral_code = $this->userRepository->checkReferralCode($referral_code);
                $user = $this->userRepository->registerUser($prefix_code, $phone_number, $referral_code);
            }
            $user_token = $this->userRepository->changeUserToken($user);
        }catch (BaseException $e){
            throw new BaseException($e->getMessage());
        }

        return $user_token;
    }
}
