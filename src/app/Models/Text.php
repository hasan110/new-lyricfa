<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;

/**
 * App\Models\Text
 *
 * @property int $id
 * @property int $music_id
 * @property int $priority
 * @property string $text_english
 * @property string $text_persian
 * @property int $start_time
 * @property int $end_time
 * @property string $comments
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */

class Text extends Model
{
    use HasFactory;

    protected $table = 'texts';
    protected $guarded = ['id'];

    /**
     * every music has a lot of texts
     * @return belongsTo
     */
    public function music(): belongsTo
    {
        return $this->belongsTo(Music::class, 'music_id');
    }
}
