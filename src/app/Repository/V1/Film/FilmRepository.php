<?php

namespace App\Repository\V1\Film;

use App\Interface\V1\Film\FilmInterface;
use App\Models\Film;
use App\Exceptions\Throwable\BaseException;
use App\Http\Resources\Film\FilmListResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FilmRepository implements FilmInterface
{
    /**
     * get film list with passed filters
     * @param array $filters
     * @return array
     * @throws BaseException
     */
    public function getList(array $filters): array
    {
        $query = $this->filter($filters)->orderBy('id', "DESC")->whereIn('type', [1, 2]);
        $paginate = null;

        if (isset($filters['limit']) && $filters['limit']) {
            $list = $query->take($filters['limit'])->get();
        } else {
            $per_page = isset($filters['per_page']) ? intval($filters['per_page']) : 25;
            $page = (isset($filters['page']) && intval($filters['page'])) ? intval($filters['page']) : 1;
            $total = $query->count();
            $list = $query->offset(($page - 1) * $per_page)->limit($per_page)->get();
            $paginate = [
                'page' => $page,
                'per_page' => $per_page,
                'total' => $total
            ];
        }

        $list = FilmListResource::collection($list);

        return [$list, $paginate];
    }

    /**
     * get film chapters using passed id
     * @param mixed $film_id
     * @return AnonymousResourceCollection
     */
    public function getChapters(mixed $film_id): AnonymousResourceCollection
    {
        $chapters = Film::query()->select('*')->where('parent', $film_id)->whereIn('type', [3, 4])->get();
        return FilmListResource::collection($chapters);
    }

    /**
     * generate query with passed filters
     * @param array $filters
     * @return mixed
     */
    public function filter(array $filters): mixed
    {
        $query = Film::query()->select('*');

        if (isset($filters['search']) && strlen($filters['search']) > 2) {
            $query = $query->where(function ($query) use ($filters) {
                $query->where('english_name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('persian_name', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['with_text'])) {
            $query = $query->with('texts');
            if (isset($filters['search_text']) && strlen($filters['search_text']) > 2) {
                $query = $query->whereHas('texts', function ($query) use ($filters) {
                    $query->where('text_english', 'like', '%' . $filters['search_text'] . '%')
                        ->orWhere('text_persian', 'like', '%' . $filters['search_text'] . '%');
                });
            }
        }

        if (isset($filters['random'])) {
            $query = $query->inRandomOrder();
        }

        if (isset($filters['film_id']) && $filters['film_id']) {
            $query = $query->where('id' , $filters['film_id']);
        }

        $query = $query->withExists(['likes as user_like_it' => function ($builder) {
            $builder->where('user_id', request()->user()->id);
        }]);

        return $query->withCount(['likes', 'comments']);
    }

    /**
     * get film data using id
     * @param mixed $film_id
     * @return Film|null
     */
    public function getFilmById(mixed $film_id): Film|null
    {
        return Film::find($film_id);
    }
}
