<?php

namespace Wooter\Commands\Team;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\PlayerLeague;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePasscodeRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\Player\PlayerLeagueRepository;
use Wooter\Wooter\Repositories\Team\TeamLeaguesRepository;
use Wooter\TeamLeague;
use Wooter\Wooter\Exceptions\Player\PlayerPasscodeNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Exceptions\Team\TeamAlreadyJoinedLeague;
use Wooter\Team;
use Wooter\PlayerTeam;

class CreateTeamLeagueJoinCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $teamId;

    /**
     * @var
     */
    private $playerId;
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $passCode;



    /**
     * @param $player_id
     * @param $league_id
     * @param $passcode
     */
    public function __construct($team_id, $player_id, $league_id, $passcode)
    {
        $this->teamId = $team_id;
        $this->leagueId = $league_id;
        $this->playerId = $player_id;
        $this->passCode = $passcode;

    }

    /**
     * @param PlayerLeagueRepository $playerLeagueRepository
     * @param LeagueRepository $leagueRepository
     * @param UserRepository $userRepository
     * @param LeaguePasscodeRepository $leaguePasscodeRepository
     * @param TeamRepository $teamRepository
     * @param TeamLeaguesRepository $teamLeaguesRepository
     * @return bool
     * @throws LeagueNotFound
     * @throws PlayerNotFound
     * @throws PlayerPasscodeNotFound
     * @throws TeamAlreadyJoinedLeague
     * @throws TeamNotFound
     */
    public function handle(PlayerLeagueRepository $playerLeagueRepository, LeagueRepository $leagueRepository, UserRepository $userRepository,  LeaguePasscodeRepository $leaguePasscodeRepository, TeamRepository $teamRepository, TeamLeaguesRepository $teamLeaguesRepository)
    {
        $passcode = $leaguePasscodeRepository->getPasscodeFromId($this->leagueId);

        if( (!$passcode) or ($passcode->passcode != $this->passCode) )
        {

            throw new PlayerPasscodeNotFound;
        }

        $player = $userRepository->getById( $this->playerId );

        if ( ! $player)
        {
            throw new PlayerNotFound;
        }

        $league = $leagueRepository->getById( $this->leagueId );

        if ( ! $league)
        {
            throw new LeagueNotFound;
        }


        $team = $teamRepository->getById($this->teamId);

        if( ! $team )
        {
            throw new TeamNotFound;
        }

        $teamLeague = $teamLeaguesRepository->getByTeamIdandLeagueId($this->teamId, $this->leagueId);

        if(  $teamLeague )
        {
            throw new TeamAlreadyJoinedLeague;
        }

        /**
         * Get List of already league players belong to team As free Agent
         * Delete their entry
         */

        $leaguePlayers = $teamRepository->getTeamPlayersJoinedLeague($this->teamId, $this->leagueId);
        foreach($leaguePlayers as $leaguePlayer => $playerModel)
        {
          $leagueJoin = $playerLeagueRepository->getByPlayerAndLeagueId($playerModel, $this->leagueId);
          $leagueJoin->delete();
        }


        $leagueTeam = new TeamLeague();
        $leagueTeam->team_id = $this->teamId;
        $leagueTeam->league_id = $this->leagueId;


        $teamLeaguesRepository->create($leagueTeam);

        return true;

    }
}
