<?php

namespace App\Http\Resources\Music;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property array $musics
 */
class PlaylistResource extends JsonResource
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
            'user_id' => $this->user_id,
            'name' => $this->name,
            'musics' => MusicListResource::collection($this->musics)
        ];
    }
}
