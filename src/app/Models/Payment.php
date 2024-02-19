<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $user_id
 * @property int $amount
 * @property string $title
 * @property string $description
 * @property string $status
 * @property string $transaction_id
 * @property string $tracking_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $guarded = ['id'];

    /**
     * every payment is related to a user
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
