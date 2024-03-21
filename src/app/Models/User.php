<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authentication;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $mobile_number
 * @property string $area_code
 * @property string $email
 * @property string $password
 * @property string $code_introduce
 * @property string $referral_code
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

    /**
     * every user has a lot of payments
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    /**
     * every user has a lot of music orders
     * @return HasMany
     */
    public function music_orders(): HasMany
    {
        return $this->hasMany(MusicOrder::class, 'user_id');
    }

    /**
     * every user has a lot of music scores
     * @return HasMany
     */
    public function music_scores(): HasMany
    {
        return $this->hasMany(MusicScore::class, 'user_id');
    }

    /**
     * every user has a lot of playlists
     * @return HasMany
     */
    public function playlists(): HasMany
    {
        return $this->hasMany(Playlist::class, 'user_id');
    }

    /**
     * every user has a lot of suggestions
     * @return HasMany
     */
    public function suggestions(): HasMany
    {
        return $this->hasMany(UserSuggestion::class, 'user_id');
    }

    /**
     * every user has a lot of words
     * @return HasMany
     */
    public function words(): HasMany
    {
        return $this->hasMany(UserWord::class, 'user_id');
    }

    /**
     * every user has a lot of files like profile image or ...
     * @return MorphMany
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable', 'fileable_type', 'fileable_id');
    }
}
