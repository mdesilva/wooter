<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Team\TeamLeaguesRepository;


class ShowLeagueTeamCommand extends Command implements SelfHandling
{
    /**
     * Create a new command instance.
     *
     * @return void
     */

    private $league_id;
    private $team_id;

    public function __construct($league_id,$team_id)
    {
        $this->league_id = $league_id;
        $this->team_id = $team_id;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(LeagueRepository $leagueRepository, TeamLeaguesRepository $teamRepository)
    {
        $league = $leagueRepository->getById($this->league_id);
        if (!$league)
        {
            throw new LeagueNotFound;
            
        }
        $team = $teamRepository->getByTeamIdandLeagueId($this->team_id,$this->league_id);
        if (!$team)
        {
            throw new TeamNotFound;
            
        }
        return $team;

    }
}
