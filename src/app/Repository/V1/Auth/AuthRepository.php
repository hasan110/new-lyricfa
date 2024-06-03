<?php

namespace App\Repository\V1\Auth;

use App\Interface\V1\Auth\AuthInterface;
use App\Interface\V1\User\UserInterface;
use App\Repository\V1\User\UserRepository;
use App\Models\SmsVerify;
use Carbon\Carbon;
use App\Exceptions\Throwable\BaseException;
use Exception;

class AuthRepository implements AuthInterface
{
    private UserRepository $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * save activation code in database for validation.
     * @param string $area_code
     * @param string $mobile_number
     * @param int $activate_code
     * @return SmsVerify
     * @throws BaseException
     */
    public function saveActivationCode(string $area_code, string $mobile_number, int $activate_code): SmsVerify
    {
        try {
            $sms_verify = new SmsVerify;
            $sms_verify->area_code = $area_code;
            $sms_verify->mobile_number = $mobile_number;
            if($mobile_number == 1234567890){
                $sms_verify->code = 1234; //google play account
            }else{
                $sms_verify->code = $activate_code;
            }
            $sms_verify->save();
        } catch (Exception $e) {
            throw new BaseException($e->getMessage(), 0, true);
        }

        return $sms_verify;
    }

    /**
     * check activation code is valid or not.
     * @param string $area_code
     * @param string $mobile_number
     * @param int $code
     * @return void
     * @throws BaseException
     */
    public function checkActivationCode(string $area_code, string $mobile_number, int $code): void
    {
        try {
            $sms_verify = SmsVerify::orderBy('id', 'DESC')->where('area_code', $area_code)->where('mobile_number', $mobile_number)->first();
            if(!$sms_verify){
                throw new BaseException(__('errors.invalid_mobile_number_in_sms_verify'));
            }

            $diff_in_minutes = Carbon::parse($sms_verify->updated_at)->diffInMinutes(Carbon::now());
            if($diff_in_minutes > 10){
                throw new BaseException(__('errors.activation_code_expired'));
            }

            if((int)$sms_verify->code !== $code){
                throw new BaseException(__('errors.activation_code_is_wrong'));
            }
            $sms_verify->delete();
        } catch (BaseException $e) {
            throw new BaseException($e->getMessage());
        }
    }

    /**
     * if user registered changes token and return user data or register user if not register.
     * @param string $area_code
     * @param string $mobile_number
     * @param string|null $referral_code
     * @return string
     * @throws BaseException
     */
    public function prepareUser(string $area_code, string $mobile_number, string|null $referral_code): string
    {
        try {
            $user = $this->userRepository->getUserByMobile($area_code , $mobile_number);
            if (!$user) {
                $referral_code = $this->userRepository->checkReferralCode($referral_code);
                $user = $this->userRepository->registerUser($area_code, $mobile_number, $referral_code);

                if ($referral_code) {
                    $this->userRepository->encourageRefer($user);
                }
            }
            $user_token = $this->userRepository->changeUserToken($user);
        } catch (BaseException $e) {
            throw new BaseException($e->getMessage());
        }

        return $user_token;
    }
}
