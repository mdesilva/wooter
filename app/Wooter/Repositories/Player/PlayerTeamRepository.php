<?php

namespace Wooter\Wooter\Repositories\Player;

use Carbon\Carbon;
use DB;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\PlayerTeam;
use Wooter\Team;
use Wooter\User;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;

class PlayerTeamRepository
{

    /**
     * @param PlayerTeam $playerTeam
     *
     * @return bool
     */
    public function create(PlayerTeam $playerTeam)
    {
        return $playerTeam->save();
    }

    /**
     * @param PlayerTeam $playerTeam
     *
     * @return bool
     */
    public function update(PlayerTeam $playerTeam)
    {
        return $playerTeam->save();
    }

    /**
     * @param $playerTeamId
     *
     * @return mixed
     */
    public function getById($playerTeamId) {
        return PlayerTeam::whereId($playerTeamId)->first();
    }

    /**
     * @param $playerId
     *
     * @return mixed
     */
    public function getAllByPlayerId($playerId)
    {
        return PlayerTeam::wherePlayerId($playerId)->get();
    }

    /**
     * @param $teamId
     *
     * @return mixed
     */
    public function getAllByTeamId($teamId)
    {
        return PlayerTeam::whereTeamId($teamId)->get();
    }

    /**
     * @param $teamId
     * @param $stageType
     * @param $stageId
     *
     * @return mixed
     */
    public function getAllByTeamIdAndStage($teamId, $stageType, $stageId)
    {
        return PlayerTeam::whereTeamId($teamId)
                    ->whereStageType($stageType)
                    ->whereStageId($stageId)->get();
    }

    /**
     * @param $teamId
     * @param $stageType
     * @param $stageId
     *
     * @return mixed
     */
    public function getPlayerIdsByTeamIdAndStage($teamId, $stageType, $stageId)
    {
        return PlayerTeam::whereTeamId($teamId)
            ->whereStageType($stageType)
            ->whereStageId($stageId)->lists('player_id')->toArray();
    }

    /**
     * @param $playerId
     * @param $stageType
     * @param $stageId
     *
     * @return bool
     */
    public function getTeamByPlayerIdAndStage($playerId, $stageType, $stageId)
    {
        $result = false;

        $playerTeam = PlayerTeam::wherePlayerId($playerId)
            ->whereStageType($stageType)
            ->whereStageId($stageId)->first();

        if ($playerTeam) {
            $result = Team::whereId($playerTeam->team_id)->first();
        }

        return $result;
    }

    /**
     * @param $playerId
     * @param $stageType
     * @param $stageId
     *
     * @return bool
     */
    public function getJerseyByPlayerIdAndStage($playerId, $stageType, $stageId)
    {
        $playerTeam = PlayerTeam::wherePlayerId($playerId)
            ->whereStageType($stageType)
            ->whereStageId($stageId)->first();

        if ($playerTeam) {
            return $playerTeam->jersey;
        }

        return '';
    }

    /**
     * @param $playerId
     * @param $stageType
     * @param $stageId
     *
     * @return mixed
     */
    public function getPlayerTeamByPlayerIdAndStage($playerId, $stageType, $stageId)
    {
        return PlayerTeam::wherePlayerId($playerId)
            ->whereStageType($stageType)
            ->whereStageId($stageId)->first();
    }

    /**
     * @param $playerId
     *
     * @return mixed
     */
    public function getTeamsByPlayerId($playerId)
    {
        $teamIds = PlayerTeam::wherePlayerId($playerId)->lists('team_id')->toArray();

        return Team::whereIn('id', $teamIds)->get();
    }

    /**
     * @param        $teamId
     * @param        $stageType
     * @param        $stageId
     *
     * @param bool   $slice
     * @param string $orderBy
     * @param string $orderDirection
     * @param int    $offset
     * @param int    $limit
     *
     * @return mixed
     */
    public function getPlayersByTeamIdAndStage($teamId, $stageType, $stageId, $slice = false, $orderBy = ApiController::DEFAULT_ORDER_BY, $orderDirection = ApiController::DEFAULT_ORDER_DIRECTION, $offset = ApiController::DEFAULT_OFFSET, $limit = ApiController::DEFAULT_LIMIT)
    {
        $playerIds = PlayerTeam::whereTeamId($teamId)
            ->whereStageType($stageType)
            ->whereStageId($stageId)->lists('player_id')->toArray();

        $result = User::whereIn('id', $playerIds)
            ->orderBy($orderBy, $orderDirection)
            ->get();

        if ($slice) {
            return $result->slice($offset, $limit);
        }

        return $result;
    }

    /**
     * @param $playerId
     * @param $teamId
     * @param $stageType
     * @param $stageId
     *
     * @return mixed
     */
    public function deleteByPlayerIdTeamIdAndStage($playerId, $teamId, $stageType, $stageId)
    {
        return PlayerTeam::whereTeamId($teamId)->wherePlayerId($playerId)
            ->whereStageType($stageType)
            ->whereStageId($stageId)->delete();
    }

    /**
     * @param $playerId
     * @param $stageType
     * @param $stageId
     *
     * @return mixed
     */
    public function deleteByPlayerIdAndStage($playerId, $stageType, $stageId)
    {
        return PlayerTeam::wherePlayerId($playerId)
            ->whereStageType($stageType)
            ->whereStageId($stageId)->delete();
    }

    /**
     * @param $teamId
     * @param $playerId
     * @param $stageType
     * @param $stageId
     *
     * @return bool
     */
    public function addTeamIdByPlayerIdAndStage($teamId, $playerId, $stageType, $stageId)
    {
        $playerTeam = PlayerTeam::wherePlayerId($playerId)
            ->whereStageType($stageType)
            ->whereStageId($stageId)->first();
        
        if (! $playerTeam) {
            $playerTeam = new PlayerTeam;
            $playerTeam->player_id = $playerId;
            $playerTeam->stage_type = $stageType;
            $playerTeam->stage_id = $stageId;
            $playerTeam->joined_at = new Carbon;
        }

        $playerTeam->team_id = $teamId;
        $playerTeam->joined_at = new Carbon;

        $playerTeam->push();

        return $playerTeam;
    }
}
