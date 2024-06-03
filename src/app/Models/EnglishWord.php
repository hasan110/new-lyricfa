<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\EnglishWord
 *
 * @property int $id
 * @property string $word
 * @property string $word_forms
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class EnglishWord extends Model
{
    use HasFactory;

    protected $table = 'english_words';
    protected $guarded = ['id'];
    protected $with = ['definitions'];

    /**
     * every english word may have a lot of definitions
     * @return HasMany
     */
    public function definitions(): HasMany
    {
        return $this->hasMany(EnglishWordDefinition::class, 'english_word_id');
    }
}
