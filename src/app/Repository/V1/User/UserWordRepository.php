<?php

namespace App\Repository\V1\User;

use App\Exceptions\Throwable\BaseException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

use App\Http\Resources\User\UserWordListResource;
use App\Interface\V1\User\UserWordInterface;
use App\Models\UserWord;
use App\Repository\V1\Dictionary\WordRepository;
use App\Interface\V1\Dictionary\WordInterface;
use App\Interface\V1\Dictionary\IdiomInterface;
use App\Repository\V1\Dictionary\IdiomRepository;

class UserWordRepository implements UserWordInterface
{
    private WordRepository $wordRepository;
    private IdiomRepository $idiomRepository;

    public function __construct(WordInterface $wordRepository, IdiomInterface $idiomRepository)
    {
        $this->wordRepository = $wordRepository;
        $this->idiomRepository = $idiomRepository;
    }

    /**
     * get user word by passed column.
     * @param string $column
     * @param mixed $value
     * @return Builder|UserWord|null
     */
    public function getUserWordBy(string $column, mixed $value): Builder|null|UserWord
    {
        return UserWord::query()->where('user_id', request()->user()->id)->where($column , $value)->first();
    }

    /**
     * get user words paginated.
     * @param Request $request
     * @return array
     */
    public function getUserWords(Request $request): array
    {
        $query = UserWord::query()->orderBy('updated_at', "ASC")->where('user_id', $request->user()->id);

        if ($request->has('status')) {
            $query = $query->where('status', $request->input('status'));
        }
        if ($request->has('search')) {
            $query = $query->where('word', 'like', '%' . $request->input('search') . '%');
        }

        $per_page = 10;
        $page = $request->has('page') ? $request->input('page') : 1;
        $total = $query->count();
        $list = $query->offset(($page - 1) * $per_page)->limit($per_page)->get();
        $paginate = [
            'page' => $page,
            'per_page' => $per_page,
            'total' => $total
        ];

        return [$list , $paginate];
    }

    /**
     * get user word reviews.
     * @param mixed $user_words
     * @return array
     */
    public function getReviews(mixed $user_words): array
    {
        $reviews = [];
        foreach ($user_words as $word) {
            $word_date = Carbon::parse($word->updated_at);
            $now = Carbon::now();
            $diff = $word_date->diff($now);
            switch ($word->status) {
                case 0:
                    $reviews[] = $word;
                    break;
                case 1:
                    if ($diff->days >= 1) {
                        $reviews[] = $word;
                    }
                    break;
                case 2:
                    if ($diff->days >= 2) {
                        $reviews[] = $word;
                    }
                    break;
                case 3:
                    if ($diff->days >= 4) {
                        $reviews[] = $word;
                    }
                    break;
                case 4:
                    if ($diff->days >= 8) {
                        $reviews[] = $word;
                    }
                    break;
                case 5:
                    if ($diff->days >= 16) {
                        $reviews[] = $word;
                    }
                    break;
                default:
                    $reviews[] = $word;
            }
        }
        return $reviews;
    }

    /**
     * get user words list
     * @param Request $request
     * @return array
     */
    public function list(Request $request): array
    {
        $query = UserWord::query()->where('user_id', $request->user()->id);
        $per_page = 25;
        $page = intval($request->input('page')) ? $request->input('page') : 1;
        $total = $query->count();
        $list = $query->offset(($page - 1) * $per_page)->limit($per_page)->get();
        $paginate = [
            'page' => $page,
            'per_page' => $per_page,
            'total' => $total
        ];

        return [UserWordListResource::collection($list), $paginate];
    }

    /**
     * add word to user words list
     * @param array $data
     * @return UserWord
     */
    public function add(array $data): UserWord
    {
        $user_word = $this->getUserWordBy('word', $data['word']);

        if (!$user_word) {
            $user_word = new UserWord();
            $user_word->word = $data['word'];
            $user_word->user_id = request()->user()->id;
            $user_word->status = 0;
            $user_word->type = $data['type'] ?? 0;
        }

        $user_word->comment_user = $data['comment_user'] ?? null;
        $user_word->save();

        return $user_word;
    }

    /**
     * remove user word using word id.
     * @param mixed $word_id
     * @return void
     * @throws BaseException
     */
    public function remove(mixed $word_id): void
    {
        $user_word = $this->getUserWordBy('id' , $word_id);

        if (!$user_word) {
            throw new BaseException(__('errors.word_not_found'));
        }

        $user_word->delete();
    }

    /**
     * get user words ready for review.
     * @param Request $request
     * @return array
     */
    public function review(Request $request): array
    {
        list($user_words , $paginate) = $this->getUserWords($request);
        $reviews = $this->getReviews($user_words);
        $final_list = [];

        foreach ($reviews as $review) {

            $word = $this->wordRepository->getWordBy('english_word', $review->word);

            if ($word) {
                $english_word = $this->wordRepository->getEnglishWordBy('word', $review->word);
                $idioms = $this->idiomRepository->getWordIdioms($review->word);
            } else {
                $map = $this->wordRepository->findMap($review->word);

                if ($map) {
                    $word = $this->wordRepository->getWordBy('english_word', $map->ci_base);
                    $english_word = $this->wordRepository->getEnglishWordBy('word', $map->ci_base);
                    $idioms = $this->idiomRepository->getWordIdioms($map->ci_base);
                } else {
                    $word = null;
                    $english_word = null;
                    $idioms = null;
                }
            }

            $final_list[] = [
                'id' => $review->id,
                'word' => $review->word,
                'type' => $review->type,
                'mean' => $word,
                "english_mean" => $english_word,
                "idioms" => $idioms,
                "user_comment" => $review->comment_user
            ];
        }

        return [$final_list, $paginate];
    }

    /**
     * get leightner box data.
     * @return array
     */
    public function box(): array
    {
        $box_data = [];
        $user_id = request()->user()->id;

        for($i = 0 ; $i <= 5 ; $i++)
        {
            $user_words = UserWord::query()->where('user_id', $user_id)->where('status', $i)->get();

            $count = 0;
            $words_count = 0;
            $idioms_count = 0;
            $comment_count = 0;

            foreach ($user_words as $user_word) {
                switch ($user_word->type) {
                    case 0:
                        $words_count++;
                    break;
                    case 1:
                        $idioms_count++;
                    break;
                    case 2:
                        $comment_count++;
                    break;
                }
                $count++;
            }

            $date = Carbon::now();
            $day = 0;
            switch ($i) {
                case 1:
                    $day = 1;
                    break;
                case 2:
                    $day = 2;
                    break;
                case 3:
                    $day = 4;
                    break;
                case 4:
                    $day = 8;
                    break;
                case 5:
                    $day = 16;
                    break;
            }

            if ($i) {
                $reviews_count = UserWord::query()->where('user_id', $user_id)->where('status', $i)->where('updated_at', '<=' , $date->subDays($day))->count();
            } else {
                $reviews_count = $count;
            }

            $box_data[$i] = [
                'status' => $i,
                'total_count' => $count,
                'words_count' => $words_count,
                'idioms_count' => $idioms_count,
                'comments_count' => $comment_count,
                'reviews_count' => $reviews_count,
            ];
        }

        return $box_data;
    }

    /**
     * user learn or not learn some words.
     * @param Request $request
     * @return void
     */
    public function learn(Request $request): void
    {
        $words_learned = $request->input('words_learned');
        $words_not_learned = $request->input('words_not_learned');

        foreach ($words_learned as $word) {
            $user_word = $this->getUserWordBy('word', $word);
            if ($user_word) {
                if((int)$user_word->status >= 5){
                    $new_status = 5;
                }else{
                    $new_status = $user_word->status + 1;
                }
                $user_word->status = $new_status;
                $user_word->save();
            }
        }

        foreach ($words_not_learned as $word) {
            $user_word = $this->getUserWordBy('word', $word);
            if ($user_word) {
                $user_word->status = 0;
                $user_word->save();
            }
        }
    }
}
