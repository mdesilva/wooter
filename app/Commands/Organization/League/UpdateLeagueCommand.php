<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeagueOrganization;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class UpdateLeagueCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $sport_id;
    /**
     * @var
     */
    private $archive;

    /**
     * Create a new command instance.
     *
     * @param $league_id
     * @param $name
     * @param $user_id
     * @param $archive
     * @param $sport_id
     */
    public function __construct($league_id, $name, $user_id, $archive = null, $sport_id)
    {
        $this->name = $name;
        $this->leagueId = $league_id;
        $this->userId = $user_id;
        $this->sport_id = $sport_id;
        $this->archive = $archive;
    }

    /**
     * Tries to create a league and save it in DB
     *
     * @param LeagueRepository $leagueRepository
     * @param UserRepository   $userRepository
     *
     * @return LeagueOrganization
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

        $league->name = $this->name;
        $league->sport_id = $this->sport_id;

        if ( ! is_null($this->archive)) {
            $league->archived = $this->archive;
        }

        $leagueRepository->update($league);

        return $league;
    }
}
