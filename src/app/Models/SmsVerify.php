<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\SmsVerify
 *
 * @property int $id
 * @property string $area_code
 * @property string $mobile_number
 * @property string $type
 * @property string $code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @mixin Builder
 */

class SmsVerify extends Model
{
    use HasFactory;

    protected $table = 'sms_verifies';
    protected $guarded = ['id'];
}
