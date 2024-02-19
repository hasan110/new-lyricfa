<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\Throwable\BaseException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Film\FilmListRequest;
use App\Interface\V1\Film\FilmInterface;
use App\Repository\V1\Film\FilmRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FilmController extends Controller
{
    private FilmRepository $filmRepository;

    public function __construct(FilmInterface $filmRepository)
    {
        $this->filmRepository = $filmRepository;
    }

    /**
     * get music list with passed filters
     * @param FilmListRequest $request
     * @return JsonResponse
     */
    public function list(FilmListRequest $request): JsonResponse
    {
        try {
            list($list, $paginate) = $this->filmRepository->getList($request->validated());
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
    public function getChapters(mixed $id): JsonResponse
    {
        try {
            $data = $this->filmRepository->getChapters($id);
            if (!$data) {
                return $this->error(__('errors.data_not_found'), [], Response::HTTP_NOT_FOUND);
            }
        } catch (BaseException|Exception $e) {
            return $this->error($e->getMessage(), []);
        }

        return $this->success($data, __('messages.success_result'));
    }
}
