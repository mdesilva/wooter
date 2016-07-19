<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Player\PlayerLeagueNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Player\PlayerLeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class UpdatePlayerLeagueCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $playerLeagueId;
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
    private $currentUserId;

    /**
     * Create a new command instance.
     *
     * @param $player_league_id
     * @param $player_id
     * @param $league_id
     * @param $current_user_id
     */
    public function __construct($player_league_id, $player_id, $league_id, $current_user_id)
    {
        $this->playerLeagueId = $player_league_id;
        $this->playerId = $player_id;
        $this->leagueId = $league_id;
        $this->currentUserId = $current_user_id;
    }

    /**
     * Execute the command.
     *
     * @param PlayerLeagueRepository|PlayerLeagueRepository $playerLeagueRepository
     * @param LeagueRepository                              $leagueRepository
     * @param UserRepository                                $userRepository
     *
     * @return
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws PlayerLeagueNotFound
     * @throws PlayerNotFound
     */
    public function handle(PlayerLeagueRepository $playerLeagueRepository,
                           UserRepository $userRepository,
                           LeagueRepository $leagueRepository,
                           UserRepository $userRepository)
    {
        $playerLeague = $playerLeagueRepository->getById($this->playerLeagueId);

        if ( ! $playerLeague)
        {
            throw new PlayerLeagueNotFound;
        }

        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league)
        {
            throw new LeagueNotFound;
        }

        $player = $userRepository->getById($this->playerId);

        if ( ! $player)
        {
            throw new PlayerNotFound;
        }

        $user = $userRepository->getById($this->currentUserId);

        if (!$user) {
            throw new UserNotFound;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        $playerLeague->league_id = $this->leagueId;
        $playerLeague->player_id = $this->playerId;

        $playerLeagueRepository->update($playerLeague);

        return $playerLeague;
    }
}
