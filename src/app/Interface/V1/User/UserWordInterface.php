<?php

namespace App\Interface\V1\User;

use App\Models\UserWord;
use Illuminate\Http\Request;

interface UserWordInterface
{
    /**
     * user word list.
     * @param Request $request
     * @return array
     */
    public function list(Request $request) :array;

    /**
     * add word to user words list.
     * @param array $data
     * @return UserWord
     */
    public function add(array $data) :UserWord;

    /**
     * remove user word using word id.
     * @param mixed $word_id
     * @return void
     */
    public function remove(mixed $word_id) :void;

    /**
     * get user words ready for review.
     * @param Request $request
     * @return array
     */
    public function review(Request $request) :array;

    /**
     * get leightner box data.
     * @return array
     */
    public function box() :array;

    /**
     * user learn or not learn some words.
     * @param Request $request
     * @return void
     */
    public function learn(Request $request) :void;
}
