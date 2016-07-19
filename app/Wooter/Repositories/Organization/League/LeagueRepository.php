<?php

namespace Wooter\Wooter\Repositories\Organization\League;

use Illuminate\Support\Facades\DB;
use Wooter\LeagueOrganization;
use Wooter\Location;

class LeagueRepository
{

    public function create(LeagueOrganization $leagueOrganization)
    {
        return $leagueOrganization->save();
    }

    public function update(LeagueOrganization $leagueOrganization)
    {
        return $leagueOrganization->save();
    }

    /**
     * @param $leagueId
     *
     * @return LeagueOrganization
     */
    public function getById($leagueId) {
        return LeagueOrganization::whereId($leagueId)->first();
    }

    public function getBySlug($slug) {
        return LeagueOrganization::whereRaw('lower(leagues.slug) LIKE lower(?)', ['%'. $slug .'%'])->first();
    }
    
    public function getFromIds($leagueIds)
    {
        return LeagueOrganization::whereIn('id', $leagueIds)->get();
    }

    public function getAllByUserId($userId)
    {
        return LeagueOrganization::whereOrganizationId($userId)->get();
    }

    public function getByOrganizationIdWithPagination($organizationId)
    {
        return LeagueOrganization::whereOrganizationId($organizationId)->paginate();
    }

    public function getByUserIdWithPagination($userId)
    {
        return $this->getByOrganizationIdWithPagination($userId);
    }

    public function getSpecialLeagues()
    {
        return LeagueOrganization::whereSpecial(true)->get();
    }

    public function search($params)
    {
        $query = DB::table('league_organizations');
        $query->select('league_organizations.id');

        if (isset($params['own']) && $params['own'] == true) {
            $query->where('league_organizations.user_id', '=', $params['user_id']);
        }
        
        if (isset($params['archived'])) {
            switch ($params['archived']) {
                case 'true':
                    $query->where('league_organizations.archived', '=', 1);
                    break;
                case 'false':
                    $query->where('league_organizations.archived', '=', 0);
                    break;

                }
        }

        $query->leftjoin('league_details', 'league_details.league_id', '=', 'league_organizations.id');
        $query->leftjoin('league_basics', 'league_basics.league_id', '=', 'league_organizations.id');

        // $query->where('active', '=', true);

        if (isset($params['name']) && $params['name'] !== '') {
            $query->whereRaw('lower(leagues.name) LIKE lower(?)', ['%'.$params['name'].'%']);
        }

        if (isset($params['sport']) && $params['sport'] !== '') {
            $query->leftjoin('sports', 'league_organizationss.sport_id', '=', 'sports.id');
            $query->whereRaw('lower(sports.name) LIKE lower(?)', ['%'.$params['sport'].'%']);
        }

        if (isset($params['min_age']) && $params['min_age'] !== '') {
            $query->where('league_basics.min_age', '>=', $params['min_age']);
        }

        if (isset($params['max_age']) && $params['max_age'] !== '') {
            $query->where('league_basics.max_age', '<=', $params['max_age']);
        }

        if (isset($params['gender']) && $params['gender'] !== '' && $params['gender'] !== 'all') {
            $query->where('league_basics.gender', '=', $params['gender']);
        }

        $distanceIn = Location::KILOMETERS;
        if (isset($params['distance_in']) && $params['distance_in'] !== '') {
            $distanceIn = $params['distance_in'];
        }

        $earthRadius = Location::DISTANCE_KILOMETERS;
        if ($distanceIn === Location::MILES) {
            $earthRadius = Location::DISTANCE_MILES;
        }

        if (isset($params['longitude']) && isset($params['latitude']) && $params['longitude'] !== '' && $params['latitude'] !== '') {

            $query->leftjoin('league_locations', 'league_locations.league_id', '=', 'league_organizations.id');

            $query->join('locations', 'locations.id' , '=', 'league_locations.location_id');

            $query->addSelect(DB::raw(
                '('. $earthRadius .' *
                    acos (
                        cos ( radians('.$params['longitude'].') )
                        * cos( radians( locations.longitude ) )
                        * cos( radians( locations.latitude ) - radians('.$params['latitude'].') )
                        + sin ( radians('.$params['longitude'].') )
                        * sin( radians( locations.longitude ) )
                    )
                ) AS distance '));

            $distance = Location::BASE_DISTANCE;

            if (isset($params['distance']) && $params['distance'] !== '') {
                $distance = $params['distance'];
            }
            $query  ->groupBy('league_organizations.id');

            if ($distance != '10000') {
                $query->havingRaw('distance < ' . $distance );
            }
        }

        $leagueIds =$query->distinct()->lists('id');

        return LeagueOrganization::whereIn('id', $leagueIds)->with('basics', 'details', 'seasons', 'locations')
            ->orderBy($params['order_by'], $params['order_direction'])
            ->get()
            ->slice($params['offset'], $params['limit']);

    }

    public function getFirstStageByLeagueId($leagueId)
    {
        $league = $this->getById($leagueId);

        if ($league || $league->season_competitions) {
            $firstSeason = $league->season_competitions()->get()->first();

            if ($firstSeason->regular_stages) {
                $firstRegularStage = $firstSeason->regular_stages()->get()->first();

                return $firstRegularStage;
            }
        }

        return false;
    }
}
