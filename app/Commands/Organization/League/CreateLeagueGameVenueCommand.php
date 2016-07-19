<?php

namespace Wooter\Commands\Organization\League;

use Wooter\City;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\DB;
use Wooter\GameVenue;
use Wooter\LeagueGameVenue;
use Wooter\LeagueLocation;
use Wooter\Location;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\GameVenueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueGameVenueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueLocationRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\LocationRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreateLeagueGameVenueCommand extends Command implements SelfHandling
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
    private $zip_code;
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
    private $city_name;
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
     * @var
     */
    private $court_name;
    /**
     * @var
     */
    private $number_of_courts;

    /**
     * Create a new command instance.
     *
     * @param $league_id
     * @param $name
     * @param $zip_code
     * @param $country_id
     * @param $state
     * @param $city_name
     * @param $user_id
     * @param $street
     * @param $longitude
     * @param $latitude
     * @param $flat
     * @param $full_address
     *
     * @param $court_name
     * @param $number_of_courts
     */
    public function __construct($league_id, $name, $zip_code, $country_id, $state, $city_name, $user_id, $street, $longitude, $latitude, $flat, $full_address, $court_name = null, $number_of_courts)
    {
        $this->leagueId = $league_id;
        $this->name = $name;
        $this->zip_code = $zip_code;
        $this->countryId = $country_id;
        $this->state = $state;
        $this->city_name= $city_name;
        $this->userId = $user_id;
        $this->street = $street;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->flat = $flat;
        $this->fullAddress = $full_address;
        $this->court_name = $court_name;
        $this->number_of_courts = $number_of_courts;
    }

    /**
     * Execute the command.
     *
     * @param GameVenueRepository                           $gameVenueRepository
     * @param LeagueRepository                              $leagueRepository
     * @param LocationRepository                            $locationRepository
     *
     * @param UserRepository                                $userRepository
     * @param GameVenueRepository|LeagueGameVenueRepository $leagueGameVenueRepository
     * @param LeagueLocationRepository                      $leagueLocationRepository
     *
     * @return
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws UserNotFound
     */
    public function handle(GameVenueRepository $gameVenueRepository,
                           LeagueRepository $leagueRepository,
                           LocationRepository $locationRepository,
                           UserRepository $userRepository,
                           LeagueGameVenueRepository $leagueGameVenueRepository,
                           LeagueLocationRepository $leagueLocationRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        $user = $userRepository->getById($this->userId);
        
        if ( ! $user) {
            throw new UserNotFound();
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        $leagueGameVenue = DB::transaction(function () use ($locationRepository, $gameVenueRepository, $leagueLocationRepository, $leagueGameVenueRepository) {

            $city = City::whereName($this->city_name)->first();

            if(is_null($city)){
                $city = new City();
                $city->country_id = $this->countryId;
                $city->name = $this->city_name;
                $city->name_localized = 'cities.name_localized';
                $city->save();
            }

            $location = new Location;
            $location->name = $this->name;
            $location->zip = $this->zip_code;
            $location->country_id = $this->countryId;
            $location->state = $this->state;
            $location->city_id = $city->id;
            $location->street = $this->street;
            $location->longitude = $this->longitude;
            $location->latitude = $this->latitude;
            $location->flat = $this->flat;
            $location->full_address = $this->fullAddress;
            $locationRepository->create($location);

            $gameVenue = new GameVenue;
            $gameVenue->location_id = $location->id;
            $gameVenue->court_name = $this->court_name;
            $gameVenue->number_of_courts = $this->number_of_courts;
            $gameVenueRepository->create($gameVenue);

            $leagueGameVenue = new LeagueGameVenue;
            $leagueGameVenue->league_id = $this->leagueId;
            $leagueGameVenue->game_venue_id = $gameVenue->id;
            $leagueGameVenueRepository->create($leagueGameVenue);

            return $leagueGameVenue;
        });

        return $leagueGameVenue;
    }
}
