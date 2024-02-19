<?php

namespace App\Interface\V1\Film;

interface FilmInterface
{
    /**
     * get film list with passed filters
     * @param array $filters
     * @return array
     */
    public function getList(array $filters): array;

    /**
     * get film chapters using passed id
     * @param mixed $film_id
     * @return mixed
     */
    public function getChapters(mixed $film_id): mixed;

    /**
     * generate query with passed filters
     * @param array $filters
     * @return mixed
     */
    public function filter(array $filters): mixed;
}
