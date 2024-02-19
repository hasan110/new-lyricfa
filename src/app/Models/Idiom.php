<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Idiom
 *
 * @property int $id
 * @property string $phrase
 * @property string $base
 * @property int $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class Idiom extends Model
{
    use HasFactory;

    protected $table = 'idioms';
    protected $guarded = ['id'];
    protected $with = ['definitions'];

    /**
     * every idiom may have a lot of definitions
     * @return HasMany
     */
    public function definitions(): HasMany
    {
        return $this->hasMany(IdiomDefinition::class, 'idiom_id');
    }
}
