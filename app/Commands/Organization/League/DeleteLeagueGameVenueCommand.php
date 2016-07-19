<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\GameVenueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\GameVenueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\LocationRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class DeleteLeagueGameVenueCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $gameVenueId;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $league_id
     * @param $game_venue_id
     *
     * @internal param $league_game_venue_id
     */
    public function __construct($user_id, $league_id, $game_venue_id)
    {
        $this->userId = $user_id;
        $this->leagueId = $league_id;
        $this->gameVenueId = $game_venue_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository          $leagueRepository
     * @param GameVenueRepository $leagueGameVenueRepository
     * @param UserRepository            $userRepository
     *
     * @return bool
     * @throws DatabaseException
     * @throws GameVenueNotFound
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws UserNotFound
     * @internal param LocationRepository $locationRepository
     *
     * @internal param GameVenueRepository $leagueGameVenueRepository
     */
    public function handle(LeagueRepository $leagueRepository, GameVenueRepository $leagueGameVenueRepository, UserRepository $userRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        return $leagueGameVenueRepository->deleteById($this->gameVenueId);
    }
}
