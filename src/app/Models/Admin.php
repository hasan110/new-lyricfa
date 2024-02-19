<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $full_name
 * @property string $username
 * @property string $password
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class Admin extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'admins';
    protected $guarded = ['id'];

    /**
     * every admin approved a lot of comments
     * @return HasMany
     */
    public function approved_comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'id_admin_confirmed');
    }

    /**
     * every admin has a lot of files like profile image or ...
     * @return MorphMany
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable', 'fileable_type', 'fileable_id');
    }
}
