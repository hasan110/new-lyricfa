<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * App\Models\Album
 *
 * @property int $id
 * @property string $english_name
 * @property string $persian_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class Album extends Model
{
    use HasFactory;

    protected $table = 'albums';
    protected $guarded = ['id'];

    /**
     * every album has a lot of musics
     * @return HasMany
     */
    public function musics(): HasMany
    {
        return $this->hasMany(Music::class, 'album_id');
    }

    /**
     * every album has one or more singers
     * @return BelongsToMany
     */
    public function singers(): BelongsToMany
    {
        return $this->belongsToMany(Singer::class, 'album_singer', 'album_id', 'singer_id');
    }

    /**
     * every album has a lot of files like banner or ...
     * @return MorphMany
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable', 'fileable_type', 'fileable_id');
    }
}
