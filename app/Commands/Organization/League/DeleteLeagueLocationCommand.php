<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueLocationNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Repositories\Organization\League\LeagueLocationRepository;

class DeleteLeagueLocationCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueLocationId;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $league_location_id
     * @param $user_id
     */
    public function __construct($league_location_id, $user_id)
    {

        $this->leagueLocationId = $league_location_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueLocationRepository $leagueLocationRepository
     *
     * @return bool
     * @throws DatabaseException
     * @throws LeagueLocationNotFound
     * @throws LeagueNotBelongToUser
     */
    public function handle(LeagueLocationRepository $leagueLocationRepository)
    {
        $leagueLocation = $leagueLocationRepository->getById($this->leagueLocationId);

        if ( ! $leagueLocation) {
            throw new LeagueLocationNotFound;
        }

        if ($leagueLocation->league->organization->user->id !== $this->userId)
        {
            throw new LeagueNotBelongToUser;
        }

        if ( ! $leagueLocation->delete())
        {
            throw new DatabaseException('There was an error deleting the league location');
        }

        return true;
    }
}
