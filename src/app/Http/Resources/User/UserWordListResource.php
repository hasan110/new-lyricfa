<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * @property int $id
 * @property string $word
 * @property string $comment_user
 * @property int $status
 * @property int $type
 */
class UserWordListResource extends JsonResource
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
            'word' => $this->word,
            'comment_user' => $this->comment_user,
            'status' => $this->status,
            'type' => $this->type
        ];
    }
}
