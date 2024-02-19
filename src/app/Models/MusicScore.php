<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Music
 *
 * @property int $id
 * @property int $user_id
 * @property int $music_id
 * @property int $score
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */

class MusicScore extends Model
{
    use HasFactory;

    protected $table = 'music_scores';
    protected $guarded = ['id'];

    /**
     * every music score is related to a user
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * every music score is related to a music
     * @return BelongsTo
     */
    public function music(): BelongsTo
    {
        return $this->belongsTo(Music::class, 'music_id');
    }
}
