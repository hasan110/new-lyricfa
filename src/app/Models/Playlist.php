<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Playlist
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class Playlist extends Model
{
    use HasFactory;

    protected $table = 'playlists';
    protected $guarded = ['id'];

    /**
     * every playlist is related to a user
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * every music has one or more playlist
     * @return BelongsToMany
     */
    public function musics(): BelongsToMany
    {
        return $this->belongsToMany(Music::class, 'playlist_music', 'playlist_id', 'music_id');
    }
}
