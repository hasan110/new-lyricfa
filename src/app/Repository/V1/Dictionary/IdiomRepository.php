<?php

namespace App\Repository\V1\Dictionary;

use App\Exceptions\Throwable\BaseException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Interface\V1\Dictionary\IdiomInterface;
use App\Models\Word;
use App\Models\EnglishWord;
use App\Models\Idiom;

class IdiomRepository implements IdiomInterface
{
    /**
     * get word idiom by base word.
     * @param string $word
     * @return Collection|array
     */
    public function getWordIdioms(string $word): array|Collection
    {
        return Idiom::query()->where('base' , $word)->get();
    }
}
