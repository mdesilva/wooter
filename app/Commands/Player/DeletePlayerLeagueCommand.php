<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Player\PlayerLeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Player\PlayerLeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class DeletePlayerLeagueCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $playerLeagueId;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $player_league_id
     * @param $user_id
     */
    public function __construct($player_league_id, $user_id)
    {
        $this->playerLeagueId = $player_league_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param PlayerLeagueRepository $playerLeagueRepository
     *
     * @param UserRepository         $userRepository
     *
     * @return bool
     * @throws DatabaseException
     * @throws NotPermissionException
     * @throws PlayerLeagueNotFound
     * @throws UserNotFound
     */
    public function handle(PlayerLeagueRepository $playerLeagueRepository, UserRepository $userRepository)
    {
        $playerLeague = $playerLeagueRepository->getById($this->playerLeagueId);

        if ( ! $playerLeague) {
            throw new PlayerLeagueNotFound;
        }

        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        if ( ! $user->hasOrganization($playerLeague->league->id)) {
            throw new NotPermissionException;
        }

        if ( ! $playerLeague->delete()) {
            throw new DatabaseException('There was an error deleting the record');
        }

        return true;
    }
}
