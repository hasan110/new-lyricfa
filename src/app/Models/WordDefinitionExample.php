<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\WordDefinitionExample
 *
 * @property int $id
 * @property int $word_definition_id
 * @property string $phrase
 * @property string $definition
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class WordDefinitionExample extends Model
{
    use HasFactory;

    protected $table = 'word_definition_examples';
    protected $guarded = ['id'];

    /**
     * every definition example is related to a word definition
     * @return BelongsTo
     */
    public function definition(): BelongsTo
    {
        return $this->belongsTo(WordDefinition::class, 'word_definition_id');
    }
}
