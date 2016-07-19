<?php

namespace Wooter\Commands\Team;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\TeamLeague;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Player\PlayerLeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePrivateInviteRepository;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\Team\TeamLeaguesRepository;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerLeagueInvitesNotFound;
use Wooter\Wooter\Exceptions\Team\TeamAlreadyJoinedLeague;



class CreateTeamLeagueJoinByInviteCommand extends Command implements SelfHandling
{

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
    private $invite_email;
    /**
     * @var
     */
    private $token;
    /**
     * @var
     */
    private $teamId;


    /**
     * @param $team_id
     * @param $league_id
     * @param $player_id
     * @param $token
     * @param $invite_email
     */

    public function __construct( $team_id, $league_id, $player_id, $token, $invite_email )
    {
        $this->leagueId = $league_id;
        $this->playerId = $player_id;
        $this->token = $token;
        $this->invite_email = $invite_email;
        $this->teamId = $team_id;

    }


    public function handle(PlayerLeagueRepository $playerLeagueRepository, LeagueRepository $leagueRepository, UserRepository $userRepository,  LeaguePrivateInviteRepository $leaguePrivateInviteRepository, TeamRepository $teamRepository, TeamLeaguesRepository $teamLeaguesRepository)
    {
        $team = $teamRepository->getById($this->teamId);

        if( ! $team )
        {
            throw new TeamNotFound;
        }

        $league = $leagueRepository->getById( $this->leagueId );

        if ( ! $league)
        {
            throw new LeagueNotFound;
        }

        $player = $userRepository->getById( $this->playerId );

        if ( ! $player)
        {
            throw new PlayerNotFound;
        }



        $invites = $leaguePrivateInviteRepository->checkJoinStatus($this->invite_email, $this->token);

        if( ! $invites )
        {

            throw new PlayerLeagueInvitesNotFound;
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


        //Override email if logged in with different email
        if($player->email != $this->invite_email)
        {
            $invites->email = $player->email;
        }

        //Update player status to invite
        $invites->status = 1;

        $leaguePrivateInviteRepository->update($invites);


        $leagueTeam = new TeamLeague();
        $leagueTeam->team_id = $this->teamId;
        $leagueTeam->league_id = $this->leagueId;


        $teamLeaguesRepository->create($leagueTeam);

        return true;



    }
}
