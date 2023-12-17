<?php

namespace App\Repository\V1\Auth;

use App\Interface\V1\Auth\AuthInterface;
use App\Interface\V1\User\UserInterface;
use App\Repository\V1\User\UserRepository;
use App\Services\Soap\Soap;
use App\Models\SmsVerify;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;

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
     * send sms filled by otp code .
     * @param string $prefix_code
     * @param string $phone_number
     * @param int $activate_code
     * @return void
     * @throws Exception
     */
    public function sendOTP(string $prefix_code, string $phone_number, int $activate_code): void
    {
        $url = config('sms_service.base_url') . config('sms_service.api_key') . config('sms_service.lookup_url');
        $receiver = $prefix_code == '98' ? $phone_number : '00'.$prefix_code.$phone_number;
        $response = Http::asForm()->post($url , [
            'receptor' => $receiver,
            'token' => $activate_code,
            'template' => 'verify'
        ]);

        $result = $response->body();
        if(!$result) {
            throw new Exception(__('messages.error_in_send_sms'));
        }
    }

    /**
     * save activation code in database for validation .
     * @param string $prefix_code
     * @param string $phone_number
     * @param string $auth_type
     * @param int $activate_code
     * @return SmsVerify
     * @throws Exception
     */
    public function saveActivationCode(string $prefix_code, string $phone_number, string $auth_type, int $activate_code): SmsVerify
    {
        try {
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
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }

        return $sms_verify;
    }

    /**
     * check activation code is valid or not .
     * @param string $prefix_code
     * @param string $phone_number
     * @param int $code
     * @return void
     * @throws Exception
     */
    public function checkActivationCode(string $prefix_code, string $phone_number, int $code): void
    {
        try {
            $sms_verify = SmsVerify::orderBy('id', 'DESC')->where('prefix_code', $prefix_code)->where('phone_number', $phone_number)->first();
            if(!$sms_verify){
                throw new Exception(__('messages.invalid_phone_number_in_sms_verify'));
            }

            $diff_in_minutes = Carbon::parse($sms_verify->updated_at)->diffInMinutes(Carbon::now());
            if($diff_in_minutes > 10){
                throw new Exception(__('messages.activation_code_expired'));
            }

            if((int)$sms_verify->code !== $code){
                throw new Exception(__('messages.activation_code_is_wrong'));
            }
            $sms_verify->delete();
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    /**
     * if user registered changes token and return user data or register user if not register .
     * @param string $prefix_code
     * @param string $phone_number
     * @param string|null $referral_code
     * @return string
     * @throws Exception
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
        }catch (Exception $e){
            throw new Exception($e->getMessage());
        }

        return $user_token;
    }
}
