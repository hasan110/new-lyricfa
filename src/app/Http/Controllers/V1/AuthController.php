<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\Throwable\ValidationException;
use App\Http\Controllers\Controller;
use App\Interface\V1\Auth\AuthInterface;
use App\Repository\V1\Auth\AuthRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function sendOtpCode(Request $request): JsonResponse
    {
        validateData($request , [
            'phone_number' => 'required|numeric',
            'prefix_code' => 'required',
        ]);

        list($prefix_code, $phone_number) = validateMobile($request->input('prefix_code'), $request->input('phone_number'));

        try {
            DB::beginTransaction();
            $activate_code = rand(1000, 9999);
            $auth_type = $this->authRepository->checkAuthType($prefix_code, $phone_number);
            $this->authRepository->sendOTP($prefix_code, $phone_number, $activate_code);
            $this->authRepository->saveActivationCode($prefix_code, $phone_number, $auth_type, $activate_code);
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            return $this->error($e->getMessage() , []);
        }

        return $this->success(null , __('messages.otp_code_successfully_sent'));
    }

    /**
     * check and validate otp code and return user data (by registering user or retrieve user data)
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function checkOtpCode(Request $request): JsonResponse
    {
        validateData($request , [
            'phone_number' => 'required|numeric',
            'prefix_code' => 'required',
            'code' => 'required|digits:4|numeric',
        ]);

        list($prefix_code, $phone_number) = validateMobile($request->input('prefix_code'), $request->input('phone_number'));

        try {
            DB::beginTransaction();
            $this->authRepository->checkActivationCode($prefix_code, $phone_number, $request->input('code'));
            $token = $this->authRepository->prepareUser($prefix_code, $phone_number, $request->input('referral_code'));
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            return $this->error($e->getMessage() , []);
        }

        return $this->success($token , __('messages.successfully_logged_in'));
    }
}
