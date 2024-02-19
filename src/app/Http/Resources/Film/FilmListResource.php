<?php

namespace App\Http\Resources\Film;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * @property int $id
 * @property string $english_name
 * @property string $persian_name
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property array $texts
 * @property array $singers
 * @property int $likes_count
 * @property int $comments_count
 * @property int $user_like_it
 * @property int|string $scores_avg_score
 */
class FilmListResource extends JsonResource
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
            'id' => $this->id,
            'english_name' => $this->english_name,
            'persian_name' => $this->persian_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'texts' => request()->with_text ? FilmListTextsResource::collection($this->texts) : [],
            'num_like' => $this->likes_count,
            'num_comment' => $this->comments_count,
            'user_like_it' => $this->user_like_it
        ];
    }
}
