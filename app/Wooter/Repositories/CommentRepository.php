<?php

namespace Wooter\Wooter\Repositories;

use Wooter\Comment;

class CommentRepository
{

    public function create(Comment $comment)
    {
        return $comment->push();
    }

    public function update(Comment $comment)
    {
        return $comment->push();
    }

    public function getById($commentId)
    {
        return Comment::whereId($commentId)->first();
    }

    public function getByUserAndItem($userId, $commentedItemId, $commentedItemType)
    {
        return Comment::whereUserId($userId)->whereCommentedItemId($commentedItemId)->whereCommentedItemType($commentedItemType)->first();
    }

    public function getCountByItem($commentedItemId, $commentedItemType)
    {
        return Comment::whereCommentedItemId($commentedItemId)->whereCommentedItemType($commentedItemType)->count();
    }

    public function getByItemWithOffsetAndLimit($commentedItemId, $commentedItemType, $offset, $limit)
    {
        return Comment::whereCommentedItemId($commentedItemId)->whereCommentedItemType($commentedItemType)->skip($offset)->take($limit)->get();
    }

}
