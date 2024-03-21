<?php

namespace App\Http\Resources\Comment;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

/**
 * @property int $id
 * @property string $comment
 * @property int|string $user_mobile_number
 * @property User $user
 */
class CommentListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $user_mobile_number = substr($this->user->mobile_number, 0, 3) . '***' . substr($this->user->mobile_number, -4);

        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'user_mobile_number' => $user_mobile_number
        ];
    }
}
