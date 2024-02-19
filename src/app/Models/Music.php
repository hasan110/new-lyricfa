<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Music
 *
 * @property int $id
 * @property string $name
 * @property string $persian_name
 * @property int $album_id
 * @property string $cat_musics
 * @property int $degree
 * @property int $music_video
 * @property int $sync_video
 * @property string $video_type
 * @property int $views
 * @property int $start_demo
 * @property int $end_demo
 * @property int $is_free
 * @property int $is_close
 * @property int $is_user_request
 * @property Carbon|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @mixin Builder
 */

class Music extends Model
{
    use HasFactory;

    protected $table = 'musics';
    protected $guarded = ['id'];

    /**
     * every music has a lot of texts
     * @return HasMany
     */
    public function texts(): HasMany
    {
        return $this->hasMany(Text::class, 'music_id');
    }

    /**
     * every music has a lot of likes
     * @return MorphMany
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable', 'likeable_type', 'likeable_id');
    }

    /**
     * every music has a lot of comments
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable', 'commentable_type', 'commentable_id');
    }

    /**
     * every music has a lot of scores
     * @return HasMany
     */
    public function scores(): HasMany
    {
        return $this->hasMany(MusicScore::class, 'music_id');
    }

    /**
     * every music has one or more singers
     * @return BelongsToMany
     */
    public function singers(): BelongsToMany
    {
        return $this->belongsToMany(Singer::class, 'music_singer', 'music_id', 'singer_id');
    }

    /**
     * every music has one or more playlists
     * @return BelongsToMany
     */
    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(Playlist::class, 'playlist_music', 'music_id', 'playlist_id');
    }

    /**
     * every music is related to an album
     * @return BelongsTo
     */
    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class, 'album_id');
    }

    /**
     * every music has a lot of files like poster, source file or ...
     * @return MorphMany
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable', 'fileable_type', 'fileable_id');
    }
}
