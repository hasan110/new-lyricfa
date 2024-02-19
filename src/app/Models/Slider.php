<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * App\Models\Slider
 *
 * @property int $id
 * @property int $id_singer_music_album
 * @property string $ids
 * @property int $type
 * @property string $title
 * @property string $description
 * @property bool $show_it
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class Slider extends Model
{
    use HasFactory;

    protected $table = 'sliders';
    protected $guarded = ['id'];

    /**
     * every film has a lot of files like banner or ...
     * @return MorphMany
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable', 'fileable_type', 'fileable_id');
    }
}
