<?php

namespace Wooter\Wooter\Repositories\Player;

use DB;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\PlayerPosition;
use Wooter\Team;
use Wooter\User;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;

class PlayerPositionRepository
{

    /**
     * @param PlayerPosition $playerPosition
     *
     * @return bool
     */
    public function create(PlayerPosition $playerPosition)
    {
        return $playerPosition->save();
    }

    /**
     * @param PlayerPosition $playerPosition
     *
     * @return bool
     */
    public function update(PlayerPosition $playerPosition)
    {
        return $playerPosition->save();
    }

    /**
     * @param $playerPositionId
     *
     * @return mixed
     */
    public function getById($playerPositionId) {
        return PlayerPosition::whereId($playerPositionId)->first();
    }

    /**
     * @param $playerId
     *
     * @return mixed
     */
    public function getAllByPlayerId($playerId)
    {
        return PlayerPosition::wherePlayerId($playerId)->get();
    }

    /**
     * @param $playerTeamId
     *
     * @return mixed
     */
    public function getByPlayerTeamId($playerTeamId)
    {
        return PlayerPosition::wherePlayerTeamId($playerTeamId)->first();
    }

}
