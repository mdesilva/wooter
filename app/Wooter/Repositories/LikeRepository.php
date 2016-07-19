<?php

namespace Wooter\Wooter\Repositories;

use Wooter\Like;

class LikeRepository
{

    public function create(Like $like)
    {
        return $like->push();
    }

    public function update(Like $like)
    {
        return $like->push();
    }

    public function getById($likeId)
    {
        return Like::whereId($likeId)->first();
    }

    public function getByUserAndItem($userId, $likedItemId, $likedItemType)
    {
        return Like::whereUserId($userId)->whereLikedItemId($likedItemId)->whereLikedItemType($likedItemType)->first();
    }

    public function getCountByItem($likedItemId, $likedItemType)
    {
        return Like::whereLikedItemId($likedItemId)->whereLikedItemType($likedItemType)->count();
    }

    public function getByItemWithOffsetAndLimit($likedItemId, $likedItemType, $offset, $limit)
    {
        return Like::whereLikedItemId($likedItemId)->whereLikedItemType($likedItemType)->skip($offset)->take($limit)->get();
    }

}
