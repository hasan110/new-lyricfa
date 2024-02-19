<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\MusicOrder
 *
 * @property int $id
 * @property int $user_id
 * @property string $music_name
 * @property string $singer_name
 * @property string $condition_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class MusicOrder extends Model
{
    use HasFactory;

    protected $table = 'music_orders';
    protected $guarded = ['id'];

    /**
     * every music order is related to a user
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
