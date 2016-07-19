<?php

namespace Wooter\Wooter\Transformers\Organization\League;

use Wooter\Wooter\Transformers\LocationTransformer;
use Wooter\Wooter\Transformers\Qnap\QnapLeagueVideoTransformer;
use Wooter\Wooter\Transformers\SportTransformer;
use Wooter\Wooter\Transformers\Team\DivisionTransformer;
use Wooter\Wooter\Transformers\Transformer;
use Wooter\Sport;
use Wooter\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class LeagueTransformer extends Transformer
{
    /**
     * @var LeagueBasicsTransformer
     */
    private $LeagueBasicsTransformer;
    /**
     * @var LeagueDetailsTransformer
     */
    private $LeagueDetailsTransformer;
    /**
     * @var LeaguePhotoTransformer
     */
    private $leaguePhotoTransformer;
    /**
     * @var LeagueVideoTransformer
     */
    private $leagueVideoTransformer;
    /**
     * @var LeagueGameVenueTransformer
     */
    private $leagueGameVenueTransformer;
    /**
     * @var LeagueSeasonsTransformer
     */
    private $leagueSeasonTransformer;

    /**
     * @var DivisionTransformer
     */
     private $divisionTransformer;
    /**
     * @var LocationTransformer
     */
    private $locationTransformer;
    /**
     * @var SportTransformer
     */
    private $sportTransformer;


    /**
     * @param LeagueBasicsTransformer    $LeagueBasicsTransformer
     * @param LeagueDetailsTransformer   $leagueDetailsTransformer
     * @param LeaguePhotoTransformer     $leaguePhotoTransformer
     * @param LeagueVideoTransformer     $leagueVideoTransformer
     * @param LocationTransformer        $locationTransformer
     * @param LeagueGameVenueTransformer $leagueGameVenueTransformer
     * @param SportTransformer           $sportTransformer
     * @param LeagueSeasonsTransformer   $leagueSeasonTransformer
     * @param DivisionTransformer        $divisionTransformer
     */
    public function __construct(LeagueBasicsTransformer $LeagueBasicsTransformer, LeagueDetailsTransformer $leagueDetailsTransformer,
                                LeaguePhotoTransformer $leaguePhotoTransformer, LeagueVideoTransformer $leagueVideoTransformer,
                                LocationTransformer $locationTransformer, LeagueGameVenueTransformer $leagueGameVenueTransformer,
                                SportTransformer $sportTransformer,
                                LeagueSeasonsTransformer $leagueSeasonTransformer, DivisionTransformer $divisionTransformer)
    {

        $this->LeagueBasicsTransformer = $LeagueBasicsTransformer;
        $this->LeagueDetailsTransformer = $leagueDetailsTransformer;
        $this->leaguePhotoTransformer = $leaguePhotoTransformer;
        $this->leagueVideoTransformer = $leagueVideoTransformer;
        $this->leagueGameVenueTransformer = $leagueGameVenueTransformer;
        $this->leagueSeasonTransformer = $leagueSeasonTransformer;
        $this->divisionTransformer = $divisionTransformer;
        $this->locationTransformer = $locationTransformer;
        $this->sportTransformer = $sportTransformer;
    }

    public function transform($league)
    {
        return [
            'id' => $league->id,
            'name' => $league->name,
            'description' => $league->description,
            'sport_id' => $league->sport->id,
            'sport_name' => $league->sport->name,
            'archived' => $league->archived,
            'phone' => $league->phone,
            'url' => $league->url,
            'instagram' => $league->instagram,
            'facebook' => $league->facebook,
            'pinterest' => $league->pinterest,
            'google' => $league->google,
            'twitter' => $league->twitter,
            'basics' => $league->basics ? $this->LeagueBasicsTransformer->transform($league->basics) : [],
            'details' => $league->details ? $this->LeagueDetailsTransformer->transform($league->details) : [],
            'locations' => $league->locations ? $this->locationTransformer->transformCollection($league->locations) : [],
            'seasons' => $league->seasons ? $this->leagueSeasonTransformer->transformCollection($league->seasons) : [],
            'photos' => $league->photos ? $this->leaguePhotoTransformer->transformCollection($league->photos) : [],
            'videos' => $league->videos ? $this->leagueVideoTransformer->transformCollection($league->videos) : [],
            'sport' => $league->sport ? $this->sportTransformer->transform($league->sport) : [],
        ];
    }
}
