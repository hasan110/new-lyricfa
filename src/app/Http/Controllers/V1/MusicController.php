<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\Throwable\BaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Music\MusicListRequest;
use App\Interface\V1\Music\MusicInterface;
use App\Repository\V1\Music\MusicRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MusicController extends Controller
{
    private MusicRepository $musicRepository;

    public function __construct(MusicInterface $musicRepository)
    {
        $this->musicRepository = $musicRepository;
    }

    /**
     * get music list with passed filters
     * @param MusicListRequest $request
     * @return JsonResponse
     */
    public function list(MusicListRequest $request): JsonResponse
    {
        try {
            list($list, $paginate) = $this->musicRepository->getList($request->validated());
        }catch (BaseException $e){
            return $this->error($e->getMessage(), []);
        }

        return $this->success($list, __('messages.success_result'), Response::HTTP_OK, $paginate);
    }

    /**
     * get music complete information
     * @param int $id
     * @return JsonResponse
     */
    public function info(mixed $id): JsonResponse
    {
        try {
            $data = $this->musicRepository->getInfo($id);
            if (!$data) {
                return $this->error(__('errors.data_not_found'), [], Response::HTTP_NOT_FOUND);
            }
        } catch (BaseException|Exception $e) {
            return $this->error($e->getMessage(), []);
        }

        return $this->success($data, __('messages.success_result'));
    }

    /**
     * add one view to music views
     * @param Request $request
     * @return JsonResponse
     */
    public function addView(Request $request): JsonResponse
    {
        try {
            $this->musicRepository->addView($request->input('music_id'));
        }catch (Exception|BaseException $e){
            return $this->error($e->getMessage(), []);
        }

        return $this->success(null, __('messages.success_operation'));
    }
}
