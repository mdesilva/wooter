<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;

class ReadLeagueTeamCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $teamId;
    
    /**
     * @var
     */
    private $leagueId;


    /**
     * Create a new command instance.
     *
     * @param $team_id
     * @param $league_id
     */
    public function __construct($team_id, $league_id)
    {
        $this->teamId = $team_id;
        $this->leagueId = $league_id;
    }

    /**
     * Execute the command.
     *
     * @param TeamRepository   $teamRepository
     * @param LeagueRepository $leagueRepository
     *
     * @return
     * @throws LeagueNotFound
     * @throws TeamNotFound
     * @internal param UserRepository $userRepository
     */
    public function handle(TeamRepository $teamRepository,
                           LeagueRepository $leagueRepository)
    {

        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        $team = $teamRepository->getById($this->teamId);

        if ( ! $team) {
            throw new TeamNotFound;
        }

        $teamInLeague = $league->teams()->whereTeamId($team->id)->first();

        if ( ! $teamInLeague) {
            throw new TeamNotFound;
        }

        return $teamInLeague;
    }
}

