<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueBasicsNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueBasicsRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class DeleteLeagueBasicsCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $league_id
     * @param $user_id
     */
    public function __construct($league_id, $user_id)
    {

        $this->leagueId = $league_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository $leagueRepository
     *
     * @param UserRepository   $userRepository
     *
     * @return bool
     * @throws DatabaseException
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws UserNotFound
     */
    public function handle(LeagueRepository $leagueRepository, UserRepository $userRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        if ( ! $league->basics->delete())
        {
            throw new DatabaseException('There was an error deleting the league basics');
        }

        return true;
    }
}
