<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeagueFeature;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueFeatureRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;

class ReadLeagueLeagueFeatureCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueId;

    /**
     * Create a new command instance.
     *
     * ReadLeagueLeagueFeatureCommand constructor.
     * @param $league_id
     */
    public function __construct($league_id) {
        $this->leagueId = $league_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueFeatureRepository $leagueFeatureRepository
     * @param LeagueRepository        $leagueRepository
     *
     * @return LeagueFeature
     * @throws LeagueNotFound
     */
    public function handle(LeagueFeatureRepository $leagueFeatureRepository, LeagueRepository $leagueRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        $leagueFeatures = $leagueFeatureRepository->getByLeagueId($this->leagueId);

        return $leagueFeatures;
    }
}
