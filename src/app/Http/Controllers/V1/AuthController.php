<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\Throwable\SendSmsException;
use App\Exceptions\Throwable\BaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\AuthenticateRequest;
use App\Http\Requests\V1\Auth\OtpRequest;
use App\Interface\V1\Auth\AuthInterface;
use App\Repository\V1\Auth\AuthRepository;
use App\Services\SMS\KaveNegarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    private AuthRepository $authRepository;

    public function __construct(AuthInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * according to auth type user can register or login and send otp code to user phone number
     * @param AuthenticateRequest $request
     * @return JsonResponse
     */
    public function authenticate(AuthenticateRequest $request): JsonResponse
    {
        list($area_code, $mobile_number) = validate_mobile($request->input('area_code'), $request->input('mobile_number'));

        try {
            DB::beginTransaction();
            $activate_code = rand(1000, 9999);
            (new KaveNegarService())->sendOtpCode($mobile_number , $activate_code);
            $this->authRepository->saveActivationCode($area_code, $mobile_number, $activate_code);
            DB::commit();
        } catch (SendSmsException|BaseException $e){
            DB::rollBack();
            return $this->error($e->getMessage(), []);
        }

        return $this->success(null, __('messages.otp_code_successfully_sent'));
    }

    /**
     * check and validate otp code and return user data (by registering user or retrieve user data)
     * @param OtpRequest $request
     * @return JsonResponse
     */
    public function otp(OtpRequest $request): JsonResponse
    {
        list($area_code, $mobile_number) = validate_mobile($request->input('area_code'), $request->input('mobile_number'));

        try {
            DB::beginTransaction();
            $this->authRepository->checkActivationCode($area_code, $mobile_number, $request->input('code'));
            $token = $this->authRepository->prepareUser($area_code, $mobile_number, $request->input('referral_code'));
            DB::commit();
        }catch (BaseException $e){
            DB::rollBack();
            return $this->error($e->getMessage(), []);
        }

        return $this->success($token, __('messages.successfully_logged_in'));
    }
}
