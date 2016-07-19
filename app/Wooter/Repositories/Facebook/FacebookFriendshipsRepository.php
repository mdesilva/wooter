<?php

namespace Wooter\Wooter\Repositories\Facebook;

use DB;
use Wooter\FacebookFriendship;

class FacebookFriendshipsRepository
{

    public function create(FacebookFriendship $facebookFriendship)
    {
        return $facebookFriendship->save();
    }

    public function update(FacebookFriendship $facebookFriendship)
    {
        return $facebookFriendship->save();
    }

    public function getById($facebookFriendshipId)
    {
        return FacebookFriendship::whereId($facebookFriendshipId)->first();
    }

    public function createFriendship($userWooterId, $userFacebookId, $facebookFriendId)
    {
        $facebookFriendship = FacebookFriendship::whereUserWooterId($userWooterId)->whereFriendFacebookId($facebookFriendId)->first();

        if ($facebookFriendship) {
            return $facebookFriendship;
        }

        $facebookFriendship = new FacebookFriendship();

        $facebookFriendship->user_wooter_id = $userWooterId;
        $facebookFriendship->user_facebook_id = $userFacebookId;
        $facebookFriendship->friend_facebook_id = $facebookFriendId;

        return $this->create($facebookFriendship);
    }
}
