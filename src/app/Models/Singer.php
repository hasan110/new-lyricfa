<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        return $this->belongsToMany(Music::class, 'music_singer' , 'singer_id' , 'music_id');
    }
}
