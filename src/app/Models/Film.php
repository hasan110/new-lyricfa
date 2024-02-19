<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * App\Models\Film
 *
 * @property int $id
 * @property string $english_name
 * @property string $persian_name
 * @property int $type
 * @property int $parent
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @mixin Builder
 */
class Film extends Model
{
    use HasFactory;

    protected $table = 'films';
    protected $guarded = ['id'];

    /**
     * every film may have a lot of texts
     * @return HasMany
     */
    public function texts(): HasMany
    {
        return $this->hasMany(FilmText::class, 'film_id');
    }

    /**
     * every film has a lot of files like poster, source file or ...
     * @return MorphMany
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable', 'fileable_type', 'fileable_id');
    }

    /**
     * every film has a lot of likes
     * @return MorphMany
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable', 'likeable_type', 'likeable_id');
    }

    /**
     * every film has a lot of comments
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable', 'commentable_type', 'commentable_id');
    }
}
