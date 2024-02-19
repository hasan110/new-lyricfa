<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TextIdiom
 *
 * @property int $id
 * @property int $text_id
 * @property int $idiom_id
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class TextIdiom extends Model
{
    use HasFactory;

    protected $table = 'text_idioms';
    protected $guarded = ['id'];
}
