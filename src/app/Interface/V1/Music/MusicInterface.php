<?php

namespace App\Interface\V1\Music;

use Exception;

interface MusicInterface
{
    /**
     * get music list with passed filters
     * @param array $filters
     * @return array
     */
    public function getList(array $filters): array;

    /**
     * get all music information
     * @param mixed $music_id
     * @return mixed
     */
    public function getInfo(mixed $music_id): mixed;

    /**
     * add one view to music views
     * @param mixed $music_id
     * @return void
     * @throws Exception
     */
    public function addView(mixed $music_id): void;

    /**
     * generate query with passed filters
     * @param array $filters
     * @return mixed
     */
    public function filter(array $filters): mixed;
}
