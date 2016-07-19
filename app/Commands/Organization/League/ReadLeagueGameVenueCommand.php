<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\GameVenueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\GameVenueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueGameVenueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;

class ReadLeagueGameVenueCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $gameVenueId;

    /**
     * @param $league_id
     * @param $game_venue_id
     */
    public function __construct($league_id, $game_venue_id)
    {
        $this->leagueId = $league_id;
        $this->gameVenueId = $game_venue_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository          $leagueRepository
     *
     * @param GameVenueRepository       $gameVenueRepository
     * @param LeagueGameVenueRepository $leagueGameVenueRepository
     *
     * @return
     * @throws GameVenueNotFound
     * @throws LeagueNotFound
     */
    public function handle(LeagueRepository $leagueRepository, GameVenueRepository $gameVenueRepository, LeagueGameVenueRepository $leagueGameVenueRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league)
        {
            throw new LeagueNotFound;
        }
        $gameVenue = $gameVenueRepository->getById($this->gameVenueId);

        if ( ! $gameVenue) {
            throw new GameVenueNotFound;
        }

        $leagueGameVenue = $leagueGameVenueRepository->getByLeagueIdAndGameVenueId($league->id, $gameVenue->id);

        if ( ! $leagueGameVenue) {
            throw new GameVenueNotFound;
        }

        return $leagueGameVenue;
    }
}
