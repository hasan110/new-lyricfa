<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserWord
 *
 * @property int $id
 * @property int $user_id
 * @property string $word
 * @property string $comment_user
 * @property int $status
 * @property int $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class UserWord extends Model
{
    use HasFactory;

    protected $table = 'user_words';
    protected $guarded = ['id'];

    /**
     * every user has a lot of words
     * @return belongsTo
     */
    public function user(): belongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
