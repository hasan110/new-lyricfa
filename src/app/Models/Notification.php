<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Notification
 *
 * @property int $id
 * @property string $uuid
 * @property string $title
 * @property string $body
 * @property string $type
 * @property int $status_send
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $guarded = ['id'];
}
