<?php

namespace App\Repository\V1\Dictionary;

use App\Exceptions\Throwable\BaseException;
use App\Models\Map;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

use App\Interface\V1\Dictionary\WordInterface;
use App\Models\Word;
use App\Models\EnglishWord;

class WordRepository implements WordInterface
{
    /**
     * get word by passed column.
     * @param string $column
     * @param mixed $value
     * @return Builder|Word|null
     */
    public function getWordBy(string $column, mixed $value): Builder|null|Word
    {
        return Word::query()->where($column , $value)->first();
    }

    /**
     * get english word by passed column.
     * @param string $column
     * @param mixed $value
     * @return Builder|EnglishWord|null
     */
    public function getEnglishWordBy(string $column, mixed $value): Builder|null|EnglishWord
    {
        return EnglishWord::query()->where($column , $value)->first();
    }

    /**
     * find mapped word.
     * @param string $word
     * @return Builder|Map|null
     */
    public function findMap(string $word): Builder|null|Map
    {
        return Map::query()->where('word' , $word)->first();
    }
}
