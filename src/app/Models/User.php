<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authentication;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $phone_number
 * @property string $prefix_code
 * @property string $national_code
 * @property string $full_name
 * @property string $email
 * @property string $address
 * @property string $birth_place
 * @property string $birth_date
 * @property string $profile_picture
 * @property string $code_introduce
 * @property string $referral_code
 * @property string $api_token
 * @property string $fcm_refresh_token
 * @property Carbon|null $expired_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @mixin Builder
 */

class User extends Authentication
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $guarded = ['id'];
}
