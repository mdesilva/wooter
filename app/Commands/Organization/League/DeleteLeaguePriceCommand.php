<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePriceNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeaguePriceRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class DeleteLeaguePriceCommand extends Command implements SelfHandling
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
    private $leaguePriceId;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $league_id
     * @param $league_price_id
     */
    public function __construct($user_id, $league_id, $league_price_id)
    {
        $this->userId = $user_id;
        $this->leagueId = $league_id;
        $this->leaguePriceId = $league_price_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository      $leagueRepository
     * @param LeaguePriceRepository $leaguePriceRepository
     * @param UserRepository        $userRepository
     *
     * @return bool
     * @throws LeagueNotFound
     * @throws LeaguePriceNotFound
     * @throws NotPermissionException
     * @throws UserNotFound
     */
    public function handle(LeagueRepository $leagueRepository, LeaguePriceRepository $leaguePriceRepository, UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user)
        {
            throw new UserNotFound;
        }

        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        $leaguePrice = $leaguePriceRepository->getById($this->leaguePriceId);

        if ( ! $leaguePrice) {
            throw new LeaguePriceNotFound;
        }

        $leaguePrice->delete();

        return true;
    }
}
