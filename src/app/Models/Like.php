<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\Like
 *
 * @property int $id
 * @property int $user_id
 * @property int $likeable_id
 * @property string $likeable_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';
    protected $guarded = ['id'];

    /**
     * every like can relate to models
     * @return MorphTo
     */

    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }
}
