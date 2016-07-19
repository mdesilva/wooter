<?php

namespace Wooter\Commands\Organization\League;

use Wooter\City;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\GameVenueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\GameVenueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueGameVenueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class UpdateLeagueGameVenueCommand extends Command implements SelfHandling
{
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
    private $cityName;
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
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $gameVenueId;
    /**
     * @var
     */
    private $courtName;
    /**
     * @var
     */
    private $numberOfCourts;

    /**
     * Create a new command instance.
     *
     * @param $league_id
     * @param $game_venue_id
     * @param $name
     * @param $zip_code
     * @param $country_id
     * @param $state
     * @param $city_name
     * @param $street
     * @param $user_id
     * @param $longitude
     * @param $latitude
     * @param $flat
     * @param $full_address
     * @param $court_name
     * @param $number_of_courts
     */
    public function __construct($league_id, $game_venue_id, $name, $zip_code, $country_id, $state, $city_name, $street, $user_id, $longitude = null, $latitude = null, $flat, $full_address, $court_name = null, $number_of_courts)
    {
        $this->name = $name;
        $this->zip = $zip_code;
        $this->countryId = $country_id;
        $this->state = $state;
        $this->cityName = $city_name;
        $this->street = $street;
        $this->userId = $user_id;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->flat = $flat;
        $this->fullAddress = $full_address;
        $this->leagueId = $league_id;
        $this->gameVenueId = $game_venue_id;
        $this->courtName = $court_name;
        $this->numberOfCourts = $number_of_courts;
    }

    public function handle(LeagueRepository $leagueRepository,
                           UserRepository $userRepository, LeagueGameVenueRepository $leagueGameVenueRepository, GameVenueRepository $gameVenueRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league)
        {
            throw new LeagueNotFound;
        }

        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        $gameVenue = $gameVenueRepository->getById($this->gameVenueId);

        if ( ! $gameVenue) {
            throw new GameVenueNotFound;
        }

        $leagueGameVenue = $leagueGameVenueRepository->getByLeagueIdAndGameVenueId($league->id, $gameVenue->id);

        if ( ! $leagueGameVenue) {
            throw new GameVenueNotFound;
        }

        $city = City::whereName($this->cityName)->first();

        if(is_null($city)){
            $city = new City();
            $city->country_id = $this->countryId;
            $city->name = $this->cityName;
            $city->name_localized = str_slug($this->cityName);
            $city->save();
        }

        $leagueGameVenue->game_venue->location->name = $this->name;
        $leagueGameVenue->game_venue->location->zip = $this->zip;
        $leagueGameVenue->game_venue->location->country_id = $this->countryId;
        $leagueGameVenue->game_venue->location->state = $this->state;
        $leagueGameVenue->game_venue->location->city_id = $city->id;
        $leagueGameVenue->game_venue->location->street = $this->street;
        $leagueGameVenue->game_venue->location->longitude = $this->longitude;
        $leagueGameVenue->game_venue->location->latitude = $this->latitude;
        $leagueGameVenue->game_venue->location->flat = $this->flat;
        $leagueGameVenue->game_venue->location->full_address = $this->fullAddress;

        $leagueGameVenue->game_venue->court_name = $this->courtName;
        $leagueGameVenue->game_venue->number_of_courts = $this->numberOfCourts;

        $leagueGameVenueRepository->update($leagueGameVenue);

        return $leagueGameVenue;
    }
}
