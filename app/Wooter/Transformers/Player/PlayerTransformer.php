<?php

namespace Wooter\Wooter\Transformers\Player;

use Carbon\Carbon;
use Wooter\LeagueOrganization;
use Wooter\Team;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;
use Wooter\Wooter\Transformers\Transformer;

class PlayerTransformer extends Transformer
{
    /**
     * @var PlayerTeamRepository
     */
    private $playerTeamRepository;

    /**
     * @param PlayerTeamRepository $playerTeamRepository
     */
    public function __construct(PlayerTeamRepository $playerTeamRepository)
    {
        $this->playerTeamRepository = $playerTeamRepository;
    }

    public function transform($player)
    {
        $result = [
            'id' => $player->id,
            'email' => $player->email,
            'first_name' => $player->first_name,
            'last_name' => $player->last_name,
            'phone' => $player->phone,
            'gender' => $player->gender,
            'picture' => $player->picture,
            'school' => $player->school,
            'position' => $player->position,
            'city' => $player->city,
            'state' => $player->state,
            'name' => $player->first_name . ' ' . $player->last_name,
            'current_team' => ''
        ];

        if (isset($this->teamId) || (isset($this->stageType) && isset($this->stageId))) {

            if (isset($this->teamId)) {
                $team = Team::whereId($this->teamId)->first();
            } else {
                $team =  $this->playerTeamRepository->getTeamByPlayerIdAndStage($player->id, $this->stageType, $this->stageId);
            }

            if ($team) {
                $playerTeam = $team->playerTeams()
                    ->where('player_id', '=', $player->id)
                    ->first();

                $result['player_info'] = [
                    'id' => $playerTeam->id,
                    'team_id' => $playerTeam->team_id,
                    'jersey' => $playerTeam->jersey,
                    'stage_id' => $playerTeam->stage_id,
                    'positions' => $playerTeam->positions->lists('position')
                ];

                $result['current_team'] = $team;
            }

        }

        $result['teams'] = $this->playerTeamRepository->getTeamsByPlayerId($player->id)->toArray();

        if ($player->birthday) {
            if ($player->birthday instanceof Carbon) {
                $result['birthday'] = $player->birthday->toDateString();
            } else {
                $result['birthday'] = $player->birthday;
            }
        }

        return $result;
    }
}