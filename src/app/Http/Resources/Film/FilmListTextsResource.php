<?php

namespace App\Http\Resources\Film;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * @property int $id
 * @property int $priority
 * @property string $text_english
 * @property string $text_persian
 * @property int $start_end_time
 * @property int $comments
 */
class FilmListTextsResource extends JsonResource
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
            'start_end_time' => $this->start_end_time,
            'comments' => $this->comments,
        ];
    }
}
