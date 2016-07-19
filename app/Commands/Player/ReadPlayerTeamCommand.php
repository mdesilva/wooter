<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\PlayerTeam;
use Wooter\Wooter\Exceptions\Player\PlayerTeamNotFound;
use Wooter\Wooter\Repositories\Player\PlayerTeamRepository;

class ReadPlayerTeamCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $playerId;
    /**
     * @var
     */
    private $teamId;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $player_id
     * @param $team_id
     * @param $user_id
     */
    public function __construct($player_id, $team_id, $user_id)
    {
        $this->playerId = $player_id;
        $this->teamId = $team_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @return
     * @throws PlayerTeamNotFound
     */
    public function handle()
    {
        $playerTeam = PlayerTeam::wherePlayerId($this->playerId)->whereTeamId($this->teamId)->first();

        if (! $playerTeam) {
            throw new PlayerTeamNotFound;
        }

        return $playerTeam->team;
    }
}
