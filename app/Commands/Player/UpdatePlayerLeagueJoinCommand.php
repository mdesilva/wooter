<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Player\PlayerLeagueNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerLeagueInvitesNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerAlreadyJoinedLeague;
use Wooter\Wooter\Exceptions\Player\PlayerInviteTokenNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Player\PlayerLeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePlayerPasscodeInviteRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePasscodeRepository;
use Wooter\PlayerLeague;


class UpdatePlayerLeagueJoinCommand extends Command implements SelfHandling
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
    private $token;
    /**
     * @var
     */
    private $currentUserId;

    /**
     * Create a new command instance.
     *
     * @param $player_league_id
     * @param $player_id
     * @param $league_id
     * @param $current_user_id
     */
    public function __construct($league_id, $player_id, $token,  $user_id)
    {
        $this->leagueId = $league_id;
        $this->playerId = $player_id;
        $this->token = $token;
        $this->currentUserId = $user_id;
    }

    /**
     * @param PlayerLeagueRepository $playerLeagueRepository
     * @param LeagueRepository $leagueRepository
     * @param UserRepository $userRepository
     * @param LeaguePlayerPasscodeInviteRepository $leaguePlayerPasscodeInviteRepository
     * @return PlayerLeague
     * @throws LeagueNotFound
     * @throws PlayerInviteTokenNotFound
     * @throws PlayerLeagueInvitationNotFound
     * @throws PlayerNotFound
     *
     * @Create insert new recored in player leagues model
     */
    public function handle(PlayerLeagueRepository $playerLeagueRepository, LeagueRepository $leagueRepository, UserRepository $userRepository, LeaguePlayerPasscodeInviteRepository $leaguePlayerPasscodeInviteRepository, LeaguePasscodeRepository $leaguePasscodeRepository)
    {

        $leaguePass = $leaguePasscodeRepository->getPasscodeFromId($this->leagueId);

        if ( ! $leaguePass)
        {
            throw new PlayerInviteTokenNotFound;
        }


        $player = $userRepository->getById($this->playerId);

        if ( ! $player)
        {
            throw new PlayerNotFound;
        }

        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league)
        {
            throw new LeagueNotFound;
        }

        $leaguePlayerInvite = $leaguePlayerPasscodeInviteRepository->getInvited($leaguePass->id, $this->playerId);

        if ( ! $leaguePlayerInvite)
        {
            throw new PlayerLeagueInvitesNotFound;
        }

        if($leaguePlayerInvite->status)
        {
            throw new PlayerAlreadyJoinedLeague;
        }

        if($leaguePass->passcode != $this->token)
        {
            throw new PlayerInviteTokenNotFound;
        }


        $leaguePlayerInvite->status = 1;
        $leaguePlayerPasscodeInviteRepository->update($leaguePlayerInvite);

        $playerLeague = new PlayerLeague();
        $playerLeague->league_id = $this->leagueId;
        $playerLeague->player_id = $this->playerId;

        $playerLeagueRepository->create($playerLeague);


        return $playerLeague;
    }
}
