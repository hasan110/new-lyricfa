<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\WordDefinition
 *
 * @property int $id
 * @property int $word_id
 * @property string $definition
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class WordDefinition extends Model
{
    use HasFactory;

    protected $table = 'word_definitions';
    protected $guarded = ['id'];
    protected $with = ['definition_examples'];

    /**
     * every definition is related to a word
     * @return BelongsTo
     */
    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class, 'word_id');
    }

    /**
     * every word definition may have a lot of examples
     * @return HasMany
     */
    public function definition_examples(): HasMany
    {
        return $this->hasMany(WordDefinitionExample::class, 'word_definition_id');
    }
}
