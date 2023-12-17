<?php

namespace App\Http\Controllers\V1;

use App\Exceptions\Throwable\ValidationException;
use App\Http\Controllers\Controller;
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
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function list(Request $request): JsonResponse
    {
        $validated = validateData($request , [
            'search'          => 'nullable',
            'search_text'     => 'nullable',
            'degree'          => 'nullable|integer',
            'music_video'     => 'nullable|boolean',
            'is_user_request' => 'nullable|boolean',
            'album_id'        => 'nullable|integer',
            'with_text'       => 'nullable|boolean',
            'singer_id'       => 'nullable|integer',
            'limit'           => 'nullable|integer|min:5|max:100',
            'random'          => 'nullable|integer',
            'page'            => 'nullable|integer',
            'per_page'        => 'nullable|integer|min:5|max:100',
            'order_by'        => 'nullable|string',
            'sort_by'         => 'nullable|boolean'
        ]);

        try {
            list($list , $paginate) = $this->musicRepository->getList($validated);
        }catch (Exception $e){
            return $this->error($e->getMessage() , []);
        }

        return $this->success($list , __('messages.success_result') , Response::HTTP_OK , $paginate);
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
                return $this->error(__('messages.data_not_found') , [] , Response::HTTP_NOT_FOUND);
            }
        }catch (Exception $e){
            return $this->error($e->getMessage() , []);
        }

        return $this->success($data , __('messages.success_result'));
    }

    /**
     * add one view to music views
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addView(Request $request): JsonResponse
    {
        validateData($request , [
            'music_id' => 'required|integer',
        ]);
        try {
            $this->musicRepository->addView($request->input('music_id'));
        }catch (Exception $e){
            return $this->error($e->getMessage() , []);
        }

        return $this->success(null , __('messages.success_operation'));
    }
}
