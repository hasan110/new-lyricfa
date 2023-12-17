<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\Comment
 *
 * @property int $id
 * @property int $user_id
 * @property int $commentable_id
 * @property string $commentable_type
 * @property string $comment
 * @property int $id_admin_confirmed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $guarded = ['id'];

    /**
     * every comment can relate to models
     * @return MorphTo
     */

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
