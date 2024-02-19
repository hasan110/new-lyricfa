<?php

namespace App\Interface\V1\Comment;

use App\Exceptions\Throwable\BaseException;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;

interface CommentInterface
{
    /**
     * find commentable type by passed params
     * @param string $type
     * @param int $id
     * @return Model
     * @throws BaseException
     */
    public function getCommentable(string $type, int $id): Model;

    /**
     * get comments list using commentable
     * @param string $type
     * @param array $data
     * @return array
     */
    public function getList(string $type, array $data): array;

    /**
     * create comment on commentable
     * @param mixed $type
     * @param array $data
     * @return Comment
     * @throws BaseException
     */
    public function add(mixed $type, array $data): Comment;

    /**
     * update comment using id
     * @param mixed $type
     * @param array $data
     * @return void
     * @throws BaseException
     */
    public function edit(mixed $type, array $data): void;

    /**
     * update comment using id
     * @param mixed $type
     * @param array $data
     * @return void
     * @throws BaseException
     */
    public function remove(mixed $type, array $data): void;
}
