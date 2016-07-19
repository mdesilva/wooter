<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeaguePrice;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeaguePriceRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreateLeaguePriceCommand extends Command implements SelfHandling
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
     * @var
     */
    private $price;
    /**
     * @var
     */
    private $description;
    /**
     * @var
     */
    private $url;
    /**
     * @var
     */
    private $name;

    /**
     * Create a new command instance.
     *
     * @param $league_id
     * @param $user_id
     * @param $price
     * @param $description
     * @param $url
     * @param $name
     */
    public function __construct($league_id, $user_id, $price, $description, $url = null, $name)
    {
        $this->leagueId = $league_id;
        $this->userId = $user_id;
        $this->price = $price;
        $this->description = $description;
        $this->url = $url;
        $this->name = $name;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository      $leagueRepository
     * @param LeaguePriceRepository $leaguePriceRepository
     * @param UserRepository        $userRepository
     *
     * @return LeaguePrice
     * @throws LeagueNotFound
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

        $leaguePrice = new LeaguePrice;

        $leaguePrice->league_id = $this->leagueId;
        $leaguePrice->price = $this->price;
        $leaguePrice->description = $this->description;
        $leaguePrice->url = $this->url;
        $leaguePrice->name = $this->name;

        $leaguePriceRepository->create($leaguePrice);

        return $leaguePrice;

    }
}
