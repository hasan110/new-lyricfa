<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\IdiomDefinitionExample
 *
 * @property int $id
 * @property int $idiom_definition_id
 * @property string $phrase
 * @property string $definition
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class IdiomDefinitionExample extends Model
{
    use HasFactory;

    protected $table = 'idiom_definition_examples';
    protected $guarded = ['id'];

    /**
     * every definition example is related to an idiom definition
     * @return BelongsTo
     */
    public function definition(): BelongsTo
    {
        return $this->belongsTo(IdiomDefinition::class, 'idiom_definition_id');
    }
}
