<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\IdiomDefinition
 *
 * @property int $id
 * @property int $idiom_id
 * @property string $definition
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class IdiomDefinition extends Model
{
    use HasFactory;

    protected $table = 'idiom_definitions';
    protected $guarded = ['id'];
    protected $with = ['definition_examples'];

    /**
     * every definition is related to an idiom
     * @return BelongsTo
     */
    public function idiom(): BelongsTo
    {
        return $this->belongsTo(Idiom::class, 'idiom_id');
    }

    /**
     * every idiom definition may have a lot of examples
     * @return HasMany
     */
    public function definition_examples(): HasMany
    {
        return $this->hasMany(IdiomDefinitionExample::class, 'idiom_definition_id');
    }
}
