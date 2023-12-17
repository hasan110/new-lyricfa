<?php

namespace App\Http\Resources\Music;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * @property int $id
 * @property string $english_name
 * @property string $persian_name
 */
class MusicListSingersResource extends JsonResource
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
        ];
    }
}
