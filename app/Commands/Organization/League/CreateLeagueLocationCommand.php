<?php

namespace Wooter\Commands\Organization\League;

use Wooter\City;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\DB;
use Wooter\LeagueLocation;
use Wooter\Location;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueLocationRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\LocationRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreateLeagueLocationCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $zip;
    /**
     * @var
     */
    private $countryId;
    /**
     * @var
     */
    private $state;
    /**
     * @var
     */
    private $cityId;
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $street;
    /**
     * @var
     */
    private $longitude;
    /**
     * @var
     */
    private $latitude;
    /**
     * @var
     */
    private $flat;
    /**
     * @var
     */
    private $fullAddress;

    /**
     * Create a new command instance.
     *
     * @param $league_id
     * @param $name
     * @param $zip
     * @param $country_id
     * @param $state
     * @param $city_id
     * @param $user_id
     * @param $street
     * @param $longitude
     * @param $latitude
     * @param $flat
     * @param $full_address
     */
    public function __construct($league_id, $name, $zip, $country_id, $state, $city_id, $user_id, $street, $longitude, $latitude, $flat, $full_address)
    {
        $this->leagueId = $league_id;
        $this->name = $name;
        $this->zip = $zip;
        $this->countryId = $country_id;
        $this->state = $state;
        $this->cityId = $city_id;
        $this->userId = $user_id;
        $this->street = $street;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->flat = $flat;
        $this->fullAddress = $full_address;
    }

    /**
     * Execute the command.
     *
     * @param LeagueLocationRepository $leagueLocationRepository
     * @param UserRepository           $userRepository
     * @param LeagueRepository         $leagueRepository
     * @param LocationRepository       $locationRepository
     *
     * @return bool|LeagueLocation
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws UserNotFound
     */
    public function handle(LeagueLocationRepository $leagueLocationRepository,
                           UserRepository $userRepository,
                           LeagueRepository $leagueRepository,
                           LocationRepository $locationRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if (!$league) {
            throw new LeagueNotFound();
        }

        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        $leagueLocation = DB::transaction(function () use ($locationRepository, $leagueLocationRepository) {
            $location = new Location;
            $location->name = $this->name;
            $location->zip = $this->zip;
            $location->country_id = $this->countryId;
            $location->state = $this->state;
            $location->city_id = $this->cityId;
            $location->street = $this->street;
            $location->longitude = $this->longitude;
            $location->latitude = $this->latitude;
            $location->flat = $this->flat;
            $location->full_address = $this->fullAddress;
            $locationRepository->create($location);

            $leagueLocation = new LeagueLocation;
            $leagueLocation->league_id = $this->leagueId;
            $leagueLocation->location_id = $location->id;
            $leagueLocationRepository->create($leagueLocation);

            return $leagueLocation;
        });

        return $leagueLocation;
    }
}
