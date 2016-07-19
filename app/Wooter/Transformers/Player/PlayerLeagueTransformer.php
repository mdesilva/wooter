<?php

namespace Wooter\Wooter\Transformers\Player;

use Wooter\Wooter\Transformers\Transformer;
use Wooter\Wooter\Transformers\User\UserTransformer;

class PlayerLeagueTransformer extends Transformer
{
    /**
     * @var UserTransformer
     */
    private $userTransformer;

    /**
     * @param UserTransformer $userTransformer
     */
    public function __construct(UserTransformer $userTransformer)
    {

        $this->userTransformer = $userTransformer;
    }

    public function transform($playerLeague)
    {
        $result = [
            'id' => $playerLeague->id,
            'player_id' => $playerLeague->player_id,
            'league_id' => $playerLeague->league_id,
        ];


        $team = [];
        if ($playerLeague->player->teams)
        {
            $team = $playerLeague->player->teams->toArray();
        }

        $player = $this->userTransformer->transform($playerLeague->player);

        return array_merge($result, ['team' => $team], ['player' => $player]);
    }
}