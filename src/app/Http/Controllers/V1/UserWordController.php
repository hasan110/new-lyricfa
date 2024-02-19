<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\Throwable\ValidationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\LearnWordRequest;
use App\Http\Requests\V1\User\RemoveUserWordRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

use App\Interface\V1\User\UserWordInterface;
use App\Repository\V1\User\UserWordRepository;
use App\Http\Requests\V1\User\AddUserWordRequest;


class UserWordController extends Controller
{
    private UserWordRepository $userWordRepository;

    public function __construct(UserWordInterface $userWordRepository)
    {
        $this->userWordRepository = $userWordRepository;
    }

    /**
     * get words of user.
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        try {
            list($list, $paginate) = $this->userWordRepository->list($request);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), []);
        }
        return $this->success($list, __('messages.success_result'), Response::HTTP_OK, $paginate);
    }

    /**
     * add word to user words list
     * @param AddUserWordRequest $request
     * @return JsonResponse
     */
    public function add(AddUserWordRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $data = $this->userWordRepository->add($request->validated());
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), []);
        }
        return $this->success($data, __('messages.success_operation'));
    }

    /**
     * remove user word using word id.
     * @param RemoveUserWordRequest $request
     * @return JsonResponse
     */
    public function remove(RemoveUserWordRequest $request): JsonResponse
    {
        try {
            $this->userWordRepository->remove($request->input('user_word_id'));
        } catch (Exception $e) {
            return $this->error($e->getMessage(), []);
        }
        return $this->success(null, __('messages.success_operation'));
    }

    /**
     * get user words ready for review.
     * @param Request $request
     * @return JsonResponse
     */
    public function review(Request $request): JsonResponse
    {
        try {
            list($data, $paginate) = $this->userWordRepository->review($request);
            return $this->success(
                $data,
                __('messages.success_result'),
                Response::HTTP_OK,
                $paginate
            );
        } catch (Exception $e) {
            return $this->error($e->getMessage(), []);
        }
    }

    /**
     * get leightner box data.
     * @return JsonResponse
     */
    public function box(): JsonResponse
    {
        try {
            return $this->success(
                $this->userWordRepository->box(),
                __('messages.success_result')
            );
        } catch (Exception $e) {
            return $this->error($e->getMessage(), []);
        }
    }

    /**
     * user learn or not learn some words.
     * @param LearnWordRequest $request
     * @return JsonResponse
     */
    public function learn(LearnWordRequest $request): JsonResponse
    {
        try {
            $this->userWordRepository->learn($request);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), []);
        }
        return $this->success(null, __('messages.success_operation'));
    }
}
