<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\EnglishWordDefinition
 *
 * @property int $id
 * @property int $english_word_id
 * @property string $word_type
 * @property string $pronunciation
 * @property string $definition
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class EnglishWordDefinition extends Model
{
    use HasFactory;

    protected $table = 'english_word_definitions';
    protected $guarded = ['id'];

    /**
     * every definition is related to an english word
     * @return BelongsTo
     */
    public function english_word(): BelongsTo
    {
        return $this->belongsTo(EnglishWord::class, 'english_word_id');
    }
}
