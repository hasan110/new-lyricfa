<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * App\Models\Singer
 *
 * @property int $id
 * @property string $english_name
 * @property string $persian_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */

class Singer extends Model
{
    use HasFactory;

    protected $table = 'singers';
    protected $guarded = ['id'];

    /**
     * every music has one or more singers
     * @return BelongsToMany
     */
    public function musics(): BelongsToMany
    {
        return $this->belongsToMany(Music::class, 'music_singer', 'singer_id', 'music_id');
    }

    /**
     * every singer has a lot of likes
     * @return MorphMany
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable', 'likeable_type', 'likeable_id');
    }

    /**
     * every singer has a lot of comments
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable', 'commentable_type', 'commentable_id');
    }

    /**
     * every album has one or more singers
     * @return BelongsToMany
     */
    public function albums(): BelongsToMany
    {
        return $this->belongsToMany(Album::class, 'album_singer', 'singer_id', 'album_id');
    }

    /**
     * every singer has a lot of files like singer profile or ...
     * @return MorphMany
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable', 'fileable_type', 'fileable_id');
    }
}
