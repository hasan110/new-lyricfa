<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\FilmText
 *
 * @property int $id
 * @property int $film_id
 * @property int $priority
 * @property string $text_english
 * @property string $text_persian
 * @property string $start_end_time
 * @property string $comments
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class FilmText extends Model
{
    use HasFactory;

    protected $table = 'film_texts';
    protected $guarded = ['id'];

    /**
     * every text is related to a film
     * @return BelongsTo
     */
    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class, 'film_id');
    }
}
