<?php

namespace App\Repository\V1\Music;

use App\Http\Resources\Music\MusicListResource;
use App\Interface\V1\Music\MusicInterface;
use App\Interface\V1\Music\PlaylistInterface;
use App\Models\Playlist;
use App\Exceptions\Throwable\BaseException;
use App\Http\Resources\Music\PlaylistResource;
use Exception;
use http\Env\Request;
use Illuminate\Database\Eloquent\Builder;

class PlaylistRepository implements PlaylistInterface
{
    private MusicRepository $musicRepository;

    public function __construct(MusicInterface $musicRepository)
    {
        $this->musicRepository = $musicRepository;
    }

    /**
     * get list of user playlists.
     * @return array
     * @throws BaseException
     */
    public function getList(): array
    {
        try {
            $per_page = 12;
            $page = intval(request()->page) ? intval(request()->page) : 1;

            $query = PlayList::query()->where('user_id', request()->user()->id);

            $list = $query->with(['musics' => function($q){
                $q->take(4)->get();
            }])->offset(($page - 1) * $per_page)->limit($per_page)->get();

            foreach ($list as $item) {
                if (count($item->musics) > 0) {
                    $music_ids = array_map(function ($music){
                        return $music['id'];
                    },$item->musics->toArray());

                    if (count($music_ids) > 0) {
                        $item->musics = $this->musicRepository->searchMusics(['music_id' => $music_ids])->get();
                    }
                }
            }

            return [
                PlaylistResource::collection($list),
                [
                    'page' => $page,
                    'per_page' => $per_page,
                    'total' => $query->count()
                ]
            ];
        } catch (Exception $e) {
            throw new BaseException($e->getMessage());
        }
    }

    /**
     * create playlist for user.
     * @param array $data
     * @return Playlist
     * @throws BaseException
     */
    public function add(array $data): Playlist
    {
        try {
            if ($this->getUserPlaylistBy('name', $data['name'])) {
                throw new BaseException(__('errors.playlist_name_exists'));
            }

            $playList = new PlayList();
            $playList->user_id = request()->user()->id;
            $playList->name = $data['name'];
            $playList->save();

            return $playList;
        } catch (Exception $e) {
            throw new BaseException($e->getMessage());
        }
    }

    /**
     * edit user playlist.
     * @param array $data
     * @return Playlist
     * @throws BaseException
     */
    public function edit(array $data): Playlist
    {
        try {
            if ($this->getUserPlaylistBy('name', $data['name'])) {
                throw new BaseException(__('errors.playlist_name_exists'));
            }

            $playList = $this->getUserPlaylistBy('id',$data['playlist_id']);
            if (!$playList) {
                throw new BaseException(__('errors.playlist_not_found'));
            }

            $playList->name = $data['name'];
            $playList->save();

            return $playList;
        } catch (Exception $e) {
            throw new BaseException($e->getMessage());
        }
    }

    /**
     * remove user playlist.
     * @param mixed $playlist_id
     * @return void
     * @throws BaseException
     */
    public function remove(mixed $playlist_id): void
    {
        try {
            $playList = $this->getUserPlaylistBy('id',$playlist_id);
            if (!$playList) {
                throw new BaseException(__('errors.playlist_not_found'));
            }

            $playList->delete();

        } catch (Exception $e) {
            throw new BaseException($e->getMessage());
        }
    }

    /**
     * get list of musics in user playlist.
     * @param mixed $playlist_id
     * @return array
     * @throws BaseException
     */
    public function getMusicList(mixed $playlist_id): array
    {
        try {
            if (!$this->getUserPlaylistBy('id',$playlist_id)) {
                throw new BaseException(__('errors.playlist_not_found'));
            }

            $per_page = 24;
            $page = intval(request()->page) ? intval(request()->page) : 1;

            $query = $this->musicRepository->searchMusics(['playlist_id' => $playlist_id]);
            $list = $query->offset(($page - 1) * $per_page)->limit($per_page)->get();

            return [
                MusicListResource::collection($list),
                [
                    'page' => $page,
                    'per_page' => $per_page,
                    'total' => $query->count()
                ]
            ];
        } catch (Exception $e) {
            throw new BaseException($e->getMessage());
        }
    }

    /**
     * add music to user playlist.
     * @param mixed $playlist_id
     * @param mixed $music_id
     * @return void
     * @throws BaseException
     */
    public function addMusic(mixed $playlist_id, mixed $music_id): void
    {
        try {
            $playlist = $this->getUserPlaylistBy('id',$playlist_id);
            if (!$playlist) {
                throw new BaseException(__('errors.playlist_not_found'));
            }

            $music = $this->musicRepository->getMusicById($music_id);
            if (!$music) {
                throw new BaseException(__('errors.music_not_found'));
            }

            $playlist->musics()->sync($music_id, false);

        } catch (Exception $e) {
            throw new BaseException($e->getMessage());
        }
    }

    /**
     * remove music from user playlist.
     * @param mixed $playlist_id
     * @param mixed $music_id
     * @return void
     * @throws BaseException
     */
    public function removeMusic(mixed $playlist_id, mixed $music_id): void
    {
        try {
            $playlist = $this->getUserPlaylistBy('id',$playlist_id);
            if (!$playlist) {
                throw new BaseException(__('errors.playlist_not_found'));
            }

            $music = $this->musicRepository->getMusicById($music_id);
            if (!$music) {
                throw new BaseException(__('errors.music_not_found'));
            }

            $playlist->musics()->detach($music_id);

        } catch (Exception $e) {
            throw new BaseException($e->getMessage());
        }
    }

    /**
     * get user playlist using name.
     * @param string $column
     * @param string $value
     * @return Builder|null|Playlist
     */
    private function getUserPlaylistBy(string $column, string $value): Builder|null|Playlist
    {
        return Playlist::query()->where('user_id' , request()->user()->id)->where($column , $value)->first();
    }
}
