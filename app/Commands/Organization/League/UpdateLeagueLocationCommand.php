<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueLocationNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueLocationRepository;

class UpdateLeagueLocationCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueLocationId;
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
    private $street;
    /**
     * @var
     */
    private $userId;
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
     * @param $league_location_id
     * @param $name
     * @param $zip
     * @param $country_id
     * @param $state
     * @param $city_id
     * @param $street
     * @param $user_id
     * @param $longitude
     * @param $latitude
     * @param $flat
     * @param $full_address
     */
    public function __construct($league_location_id, $name, $zip, $country_id, $state, $city_id, $street, $user_id, $longitude, $latitude, $flat, $full_address)
    {
        $this->leagueLocationId = $league_location_id;
        $this->name = $name;
        $this->zip = $zip;
        $this->countryId = $country_id;
        $this->state = $state;
        $this->cityId = $city_id;
        $this->street = $street;
        $this->userId = $user_id;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->flat = $flat;
        $this->fullAddress = $full_address;
    }

    /**
     * Execute the command.
     *
     * @param LeagueLocationRepository $leagueLocationRepository
     * @return array
     * @throws LeagueLocationNotFound
     * @throws LeagueNotBelongToUser
     */
    public function handle(LeagueLocationRepository $leagueLocationRepository)
    {
        $leagueLocation = $leagueLocationRepository->getById($this->leagueLocationId);

        if ( ! $leagueLocation)
        {
            throw new LeagueLocationNotFound;
        }

        if ($leagueLocation->league->organization->user->id !== $this->userId) {
            throw new LeagueNotBelongToUser;
        }

        $leagueLocation->location->name = $this->name;
        $leagueLocation->location->zip = $this->zip;
        $leagueLocation->location->country_id = $this->countryId;
        $leagueLocation->location->state = $this->state;
        $leagueLocation->location->city_id = $this->cityId;
        $leagueLocation->location->street = $this->street;
        $leagueLocation->location->longitude = $this->longitude;
        $leagueLocation->location->latitude = $this->latitude;
        $leagueLocation->location->flat = $this->flat;
        $leagueLocation->location->full_address = $this->fullAddress;
        $leagueLocationRepository->update($leagueLocation);

        return $leagueLocation;
    }
}
