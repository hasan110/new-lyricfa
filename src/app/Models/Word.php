<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Word
 *
 * @property int $id
 * @property string $english_word
 * @property string $word_types
 * @property string $pronunciation
 * @property int $uk_pron
 * @property int $us_pron
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class Word extends Model
{
    use HasFactory;

    protected $table = 'words';
    protected $guarded = ['id'];
    protected $with = ['definitions'];

    /**
     * every word may have a lot of definitions
     * @return HasMany
     */
    public function definitions(): HasMany
    {
        return $this->hasMany(WordDefinition::class, 'word_id');
    }
}
