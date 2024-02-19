<?php

namespace App\Repository\V1\Music;

use App\Interface\V1\Music\MusicInterface;
use App\Models\Music;
use App\Exceptions\Throwable\BaseException;
use App\Http\Resources\Music\MusicListResource;

class MusicRepository implements MusicInterface
{
    private array $order_by_fields = [
        'id',
        'views',
        'published_at'
    ];

    /**
     * get music list with passed filters
     * @param array $filters
     * @return array
     * @throws BaseException
     */
    public function getList(array $filters): array
    {
        $query = $this->filter($filters);
        $paginate = null;

        if (isset($filters['limit']) && $filters['limit']) {
            $list = $query->take($filters['limit'])->get();
        } else {
            $per_page = isset($filters['per_page']) ? intval($filters['per_page']) : 25;
            $page = intval($filters['page']) ?? 1;
            $total = $query->count();
            $list = $query->offset(($page - 1) * $per_page)->limit($per_page)->get();
            $paginate = [
                'page' => $page,
                'per_page' => $per_page,
                'total' => $total
            ];
        }

        $list = MusicListResource::collection($list);

        return [$list, $paginate];
    }

    /**
     * get all music information
     * @param mixed $music_id
     * @return MusicListResource|null
     * @throws BaseException
     */
    public function getInfo(mixed $music_id): MusicListResource|null
    {
        $music = $this->filter([
            'music_id' => $music_id
        ])->first();

        if (!$music) return null;

        return new MusicListResource($music);
    }

    /**
     * add one view to music views
     * @param mixed $music_id
     * @return void
     * @throws BaseException
     */
    public function addView(mixed $music_id): void
    {
        $music = $this->filter([
            'music_id' => $music_id
        ])->first();

        if (!$music) {
            throw new BaseException(__('errors.data_not_found'));
        }

        $music->increment('views');
    }

    /**
     * generate query with passed filters
     * @param array $filters
     * @return mixed
     */
    public function filter(array $filters): mixed
    {
        $query = Music::query()->select('*');

        if (isset($filters['search']) && strlen($filters['search']) > 2) {
            $query = $query->where(function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('persian_name', 'like', '%' . $filters['search'] . '%');
            });
        }
        if (isset($filters['singer_id'])) {
            $query = $query->whereHas('singers', function ($query) use ($filters) {
                $query->where('singer_id', $filters['singer_id']);
            });
        }
        if (isset($filters['degree'])) {
            $query = $query->where('degree', $filters['degree']);
        }
        if (isset($filters['album_id'])) {
            $query = $query->where('album_id', $filters['album_id']);
        }
        if (isset($filters['music_video'])) {
            $query = $query->where('music_video', $filters['music_video']);
        }
        if (isset($filters['is_user_request'])) {
            $query = $query->where('is_user_request', $filters['is_user_request']);
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
        if (isset($filters['order_by'])) {
            $order_by = in_array($filters['order_by'], $this->order_by_fields) ? $filters['order_by'] : 'id';
            $sort_by = (isset($filters['sort_by']) && $filters['sort_by']) ? 'asc' : 'desc';
            $query = $query->orderBy($order_by, $sort_by);
        }
        if (isset($filters['random'])) {
            $query = $query->inRandomOrder();
        }
        if (isset($filters['music_id']) && $filters['music_id']) {
            $query = $query->where('id' , $filters['music_id']);
        }

        $query = $query->withExists(['likes as user_like_it' => function ($builder) {
            $builder->where('user_id', request()->user()->id);
        }]);

        return $query->with('singers')->withCount(['likes', 'comments'])->withAvg('scores', 'score');
    }

    /**
     * get music data using id
     * @param mixed $music_id
     * @return Music|null
     */
    public function getMusicById(mixed $music_id): Music|null
    {
        return Music::find($music_id);
    }
}
