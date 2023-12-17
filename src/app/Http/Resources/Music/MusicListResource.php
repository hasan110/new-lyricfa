<?php

namespace App\Http\Resources\Music;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * @property int $id
 * @property string $name
 * @property string $persian_name
 * @property int $degree
 * @property int $music_video
 * @property int $views
 * @property int $is_free
 * @property int $is_close
 * @property int $is_user_request
 * @property mixed $published_at
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property array $texts
 * @property array $singers
 * @property int $likes_count
 * @property int $comments_count
 * @property int $user_like_it
 * @property int|string $scores_avg_score
 */
class MusicListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'music' => [
                'id' => $this->id,
                'name' => $this->name,
                'persian_name' => $this->persian_name,
                'degree' => $this->degree,
                'music_video' => $this->music_video,
                'views' => $this->views,
                'is_free' => $this->is_free,
                'is_close' => $this->is_close,
                'is_user_request' => $this->is_user_request,
                'published_at' => $this->published_at,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'texts' => request()->with_text ? MusicListTextsResource::collection($this->texts) : [],
            'singers' => MusicListSingersResource::collection($this->singers),
            'num_like' => $this->likes_count,
            'num_comment' => $this->comments_count,
            'user_like_it' => $this->user_like_it,
            'average_score' => round($this->scores_avg_score , 2),
        ];
    }
}
