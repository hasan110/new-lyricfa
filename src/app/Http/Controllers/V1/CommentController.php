<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\Throwable\BaseException;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests\V1\Comment\CommentCreateRequest;
use App\Http\Requests\V1\Comment\CommentListRequest;
use App\Http\Requests\V1\Comment\CommentUpdateRequest;
use App\Http\Requests\V1\Comment\CommentDeleteRequest;

use App\Interface\V1\Comment\CommentInterface;
use App\Repository\V1\Comment\CommentRepository;

class CommentController extends Controller
{
    private CommentRepository $commentRepository;

    public function __construct(CommentInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * get comments for a commentable by id.
     * @param mixed $type
     * @param CommentListRequest $request
     * @return JsonResponse
     */
    public function list(mixed $type ,CommentListRequest $request): JsonResponse
    {
        try {
            list($list, $paginate) = $this->commentRepository->getList($type, $request->validated());
        }catch (BaseException $e){
            return $this->error($e->getMessage(), []);
        }

        return $this->success($list, __('messages.success_result'), Response::HTTP_OK, $paginate);
    }

    /**
     * create comment in commentable.
     * @param mixed $type
     * @param CommentCreateRequest $request
     * @return JsonResponse
     */
    public function add(mixed $type, CommentCreateRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->commentRepository->add($type, $request->validated());
            DB::commit();
        } catch (BaseException|Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), []);
        }

        return $this->success(null, __('messages.success_operation'));
    }

    /**
     * update comment by id.
     * @param mixed $type
     * @param CommentUpdateRequest $request
     * @return JsonResponse
     */
    public function edit(mixed $type, CommentUpdateRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->commentRepository->edit($type, $request->validated());
            DB::commit();
        } catch (BaseException|Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), []);
        }

        return $this->success(null, __('messages.success_operation'));
    }

    /**
     * delete comment by id.
     * @param mixed $type
     * @param CommentDeleteRequest $request
     * @return JsonResponse
     */
    public function remove(mixed $type, CommentDeleteRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->commentRepository->remove($type, $request->validated());
            DB::commit();
        } catch (BaseException|Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), []);
        }

        return $this->success(null, __('messages.success_operation'));
    }
}
