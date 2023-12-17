<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Setting
 *
 * @property string $key
 * @property string $value
 * @property string $description
 */

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';
    protected $guarded = [];
}
