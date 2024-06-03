<?php

namespace App\Interface\V1\Music;

use App\Exceptions\Throwable\BaseException;
use App\Models\Playlist;

interface PlaylistInterface
{
    /**
     * get list of user playlists
     * @return array
     * @throws BaseException
     */
    public function getList(): array;


    /**
     * create playlist for user.
     * @param array $data
     * @return Playlist
     * @throws BaseException
     */
    public function add(array $data): Playlist;


    /**
     * edit user playlist.
     * @param array $data
     * @return Playlist
     * @throws BaseException
     */
    public function edit(array $data): Playlist;


    /**
     * remove user playlist.
     * @param mixed $playlist_id
     * @return void
     * @throws BaseException
     */
    public function remove(mixed $playlist_id): void;

    /**
     * get list of musics in user playlist.
     * @param mixed $playlist_id
     * @return array
     * @throws BaseException
     */
    public function getMusicList(mixed $playlist_id): array;

    /**
     * add music to user playlist.
     * @param mixed $playlist_id
     * @param mixed $music_id
     * @return void
     * @throws BaseException
     */
    public function addMusic(mixed $playlist_id, mixed $music_id): void;

    /**
     * remove music from user playlist.
     * @param mixed $playlist_id
     * @param mixed $music_id
     * @return void
     * @throws BaseException
     */
    public function removeMusic(mixed $playlist_id, mixed $music_id): void;
}
