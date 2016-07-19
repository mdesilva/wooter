<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\PlayerLeague;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Player\PlayerLeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePasscodeRepository;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerAlreadyJoinedLeague;
use Wooter\Wooter\Exceptions\Player\PlayerAlreadyJoinedTeamAsLeague;
use Wooter\Wooter\Exceptions\Player\PlayerPasscodeNotFound;



class CreatePlayerLeagueJoinCommand extends Command implements SelfHandling
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
    private $passCode;
    /**
     * @var
     */
    private $currentUserId;

    /**
     * @param $league_id
     * @param $player_id
     * @param $passcode
     * @param $user_id
     */
    public function __construct($league_id, $player_id, $passcode,  $user_id)
    {
        $this->leagueId = $league_id;
        $this->playerId = $player_id;
        $this->passCode = $passcode;
        $this->currentUserId = $user_id;
    }

    /**
     * @param PlayerLeagueRepository   $playerLeagueRepository
     * @param LeagueRepository         $leagueRepository
     * @param UserRepository           $userRepository
     * @param LeaguePasscodeRepository $leaguePasscodeRepository
     *
     * @return PlayerLeague
     * @throws LeagueNotFound
     * @throws PlayerAlreadyJoinedLeague
     * @throws PlayerAlreadyJoinedTeamAsLeague
     * @throws PlayerNotFound
     * @throws PlayerPasscodeNotFound
     * @internal param TeamLeaguesRepository $teamLeaguesRepository
     */
    public function handle(PlayerLeagueRepository $playerLeagueRepository, LeagueRepository $leagueRepository, UserRepository $userRepository,  LeaguePasscodeRepository $leaguePasscodeRepository)
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

        $playerLeague = $playerLeagueRepository->getByPlayerAndLeagueId( $this->playerId, $this->leagueId );

        if ( $playerLeague )
        {
            throw new PlayerAlreadyJoinedLeague;
        }



        $playerTeam = $userRepository->getTeamPlayingLeague($this->playerId, $this->leagueId);

        if( $playerTeam )
        {
            throw new PlayerAlreadyJoinedTeamAsLeague;
        }


        $playerLeague = new PlayerLeague();
        $playerLeague->league_id = $this->leagueId;
        $playerLeague->player_id = $this->playerId;

        $playerLeagueRepository->create($playerLeague);


        return $playerLeague;
    }
}
