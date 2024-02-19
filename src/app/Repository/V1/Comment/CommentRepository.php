<?php

namespace App\Repository\V1\Comment;

use App\Interface\V1\Comment\CommentInterface;
use App\Models\Comment;
use App\Exceptions\Throwable\BaseException;
use App\Http\Resources\Comment\CommentListResource;
use App\Repository\V1\Film\FilmRepository;
use App\Repository\V1\Music\MusicRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CommentRepository implements CommentInterface
{
    /**
     * find commentable type by passed params
     * @param string $type
     * @param int $id
     * @return Model
     * @throws BaseException
     */
    public function getCommentable(string $type, int $id): Model
    {
        switch ($type) {
            case 'music':
                $commentable = (new MusicRepository())->getMusicById($id);
                break;
            case 'film':
                $commentable = (new FilmRepository())->getFilmById($id);
                break;
            default:
                throw new BaseException(__('errors.invalid_commentable'));
        }

        if (!$commentable) {
            throw new BaseException(__('errors.commentable_not_found'));
        }

        return $commentable;
    }

    /**
     * get comments list using commentable
     * @param string $type
     * @param array $data
     * @return array
     * @throws BaseException
     */
    public function getList(string $type, array $data): array
    {
        $query = $this->getCommentable($type , $data['commentable_id'])->comments()->where('id_admin_confirmed' , '>' , 0)->orderBy('id', "DESC");
        $paginate = null;

        if (isset($data['limit']) && $data['limit']) {
            $list = $query->take($data['limit'])->get();
        } else {
            $per_page = isset($data['per_page']) ? intval($data['per_page']) : 25;
            $page = isset($data['page']) ? intval($data['page']) : 1;
            $total = $query->count();
            $list = $query->offset(($page - 1) * $per_page)->limit($per_page)->get();
            $paginate = [
                'page' => $page,
                'per_page' => $per_page,
                'total' => $total
            ];
        }

        return [CommentListResource::collection($list), $paginate];
    }

    /**
     * create comment on commentable
     * @param mixed $type
     * @param array $data
     * @return Comment
     * @throws BaseException
     */
    public function add(mixed $type, array $data): Comment
    {
        return $this->getCommentable($type , $data['commentable_id'])
            ->comments()
            ->create([
                'user_id' => request()->user()->id,
                'comment' => $data['comment']
            ]
        );
    }

    /**
     * update comment using id
     * @param mixed $type
     * @param array $data
     * @return void
     * @throws BaseException
     */
    public function edit(mixed $type, array $data): void
    {
        $comment = $this->getCommentable($type , $data['commentable_id'])->comments()->where('id' , $data['id'])->first();

        if (!$comment) {
            throw new BaseException(__('errors.comment_not_found'));
        }

        if ($comment->user_id !== request()->user()->id) {
            throw new BaseException(__('errors.comment_edit_access_denied'));
        }

        $comment->update([
            'comment' => $data['comment']
        ]);
    }

    /**
     * update comment using id
     * @param mixed $type
     * @param array $data
     * @return void
     * @throws BaseException
     */
    public function remove(mixed $type, array $data): void
    {
        $comment = $this->getCommentable($type , $data['commentable_id'])->comments()->where('id' , $data['id'])->first();

        if (!$comment) {
            throw new BaseException(__('errors.comment_not_found'));
        }

        if ($comment->user_id !== request()->user()->id) {
            throw new BaseException(__('errors.comment_edit_access_denied'));
        }

        $comment->delete();
    }
}
