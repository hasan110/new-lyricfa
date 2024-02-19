<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\File
 *
 * @property int $id
 * @property string $fileable_type
 * @property string $fileable_id
 * @property string $name
 * @property string $path
 * @property string $type
 * @property string $extension
 * @property string $size
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class File extends Model
{
    use HasFactory;

    protected $table = 'files';
    protected $guarded = ['id'];

    /**
     * every like can relate to models
     * @return MorphTo
     */

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
