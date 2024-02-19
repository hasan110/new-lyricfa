<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\Throwable\ValidationException;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Interface\V1\User\UserInterface;
use App\Repository\V1\User\UserRepository;


class UserController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * get all user data need for app
     * @param Request $request
     * @return JsonResponse
     */
    public function getUser(Request $request): JsonResponse
    {
        try {
            return $this->success(
                $this->userRepository->getUserData($request),
                __('messages.success_result')
            );
        } catch (Exception $e) {
            return $this->error($e->getMessage(), []);
        }
    }

    /**
     * add some subscription to user
     * @param Request $request
     * @return JsonResponse
     */
    public function addSubscription(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $user = $this->userRepository->addSubscription($request->user(), 30, 'minute');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), []);
        }

        return $this->success(Carbon::parse($user->expired_at)->format('Y-m-d H:i'), __('messages.success_operation'));
    }

    /**
     * save google fcm refresh token
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function saveFcmToken(Request $request): JsonResponse
    {
        validateData($request, [
            'fcm_token' => 'required'
        ]);

        try {
            DB::beginTransaction();
            $this->userRepository->saveFcmToken($request->user(), $request->input('fcm_token'));
            $user = $this->userRepository->getUserData($request);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), []);
        }

        return $this->success($user, __('messages.success_operation'));
    }
}
