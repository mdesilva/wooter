<?php

namespace Wooter\Wooter\Transformers\Follow;

use Wooter\Wooter\Transformers\Transformer;

class FollowLeagueTransformer extends Transformer {

    public function transform($followLeague) {

        return [
            'id' => $followLeague->id,
            'name' => $followLeague->league->name,
            'league_id' => $followLeague->league_id,
            'user_id' => $followLeague->user_id,
            'status' => $followLeague->status,
        ];
    }
}
