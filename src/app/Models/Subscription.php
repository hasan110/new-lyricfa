<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Subscription
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $amount
 * @property int $subscription_days
 * @property int $without_discount
 * @property string $business_plan
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';
    protected $guarded = ['id'];
}
