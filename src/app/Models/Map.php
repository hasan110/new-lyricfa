<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Map
 *
 * @property string $word
 * @property string $ci_base
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class Map extends Model
{
    use HasFactory;

    protected $table = 'maps';
    protected $guarded = [];
}
