<?php

namespace App\Http\Resources\Music;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * @property int $id
 * @property int $priority
 * @property string $text_english
 * @property string $text_persian
 * @property int $start_time
 * @property int $end_time
 */
class MusicListTextsResource extends JsonResource
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
            'priority' => $this->priority,
            'text_english' => $this->text_english,
            'text_persian' => $this->text_persian,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ];
    }
}
