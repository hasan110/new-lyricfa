<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserSuggestion
 *
 * @property int $id
 * @property int $user_id
 * @property int $text_id
 * @property string $comment_user
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class UserSuggestion extends Model
{
    use HasFactory;

    protected $table = 'user_suggestions';
    protected $guarded = ['id'];

    /**
     * every user has a lot of suggestions
     * @return belongsTo
     */
    public function user(): belongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * every text has a lot of suggestions
     * @return belongsTo
     */
    public function text(): belongsTo
    {
        return $this->belongsTo(Text::class, 'text_id');
    }
}
