<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Music\CreatePlaylistRequest;
use App\Http\Requests\V1\Music\UpdatePlaylistRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

use App\Interface\V1\Music\PlaylistInterface;
use App\Repository\V1\Music\PlaylistRepository;


class PlaylistController extends Controller
{
    private PlaylistRepository $playlistRepository;

    public function __construct(PlaylistInterface $playlistRepository)
    {
        $this->playlistRepository = $playlistRepository;
    }

    /**
     * get list of user playlists.
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        try {
            list($list, $paginate) = $this->playlistRepository->getList();
        } catch (Exception $e) {
            return $this->error($e->getMessage(), []);
        }
        return $this->success($list, __('messages.success_result'), Response::HTTP_OK, $paginate);
    }

    /**
     * create playlist for user.
     * @param CreatePlaylistRequest $request
     * @return JsonResponse
     */
    public function add(CreatePlaylistRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $playlist = $this->playlistRepository->add($request->validated());
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), []);
        }
        return $this->success($playlist, __('messages.success_operation'));
    }

    /**
     * edit user playlist.
     * @param UpdatePlaylistRequest $request
     * @return JsonResponse
     */
    public function edit(UpdatePlaylistRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $playlist = $this->playlistRepository->edit($request->validated());
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), []);
        }
        return $this->success($playlist, __('messages.success_operation'));
    }

    /**
     * remove user playlist.
     * @param Request $request
     * @return JsonResponse
     */
    public function remove(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->playlistRepository->remove($request->input('playlist_id'));
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), []);
        }
        return $this->success(null, __('messages.success_operation'));
    }

    /**
     * get list of musics in user playlist.
     * @param Request $request
     * @return JsonResponse
     */
    public function getMusicList(Request $request): JsonResponse
    {
        try {
            list($list, $paginate) = $this->playlistRepository->getMusicList($request->input('playlist_id'));
        } catch (Exception $e) {
            return $this->error($e->getMessage(), []);
        }
        return $this->success($list, __('messages.success_result'), Response::HTTP_OK, $paginate);
    }

    /**
     * add music to user playlist.
     * @param Request $request
     * @return JsonResponse
     */
    public function addMusic(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->playlistRepository->addMusic($request->input('playlist_id'), $request->input('music_id'));
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), []);
        }
        return $this->success(null, __('messages.success_operation'));
    }

    /**
     * remove music from user playlist.
     * @param Request $request
     * @return JsonResponse
     */
    public function removeMusic(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->playlistRepository->removeMusic($request->input('playlist_id'), $request->input('music_id'));
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), []);
        }
        return $this->success(null, __('messages.success_operation'));
    }
}
