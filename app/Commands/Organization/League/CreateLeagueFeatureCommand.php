<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueFeatureRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\LeagueFeature;
use Wooter\LeagueLeagueFeature;

class CreateLeagueFeatureCommand extends Command implements SelfHandling
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
    private $featureId;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $league_id
     * @param $feature_id
     */
    public function __construct($user_id, $league_id, $feature_id)
    {
        $this->userId = $user_id;
        $this->leagueId = $league_id;
        $this->featureId = $feature_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository        $leagueRepository
     * @param LeagueFeatureRepository $leagueFeatureRepository
     *
     * @return LeagueFeature
     * @throws LeagueNotFound
     */
    public function handle(LeagueRepository $leagueRepository, LeagueFeatureRepository $leagueFeatureRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound();
        }
        
        $leagueFeature = new LeagueFeature();
        $leagueFeature->league_id = $this->leagueId;
        $leagueFeature->feature_id = $this->featureId;

        $leagueFeatureRepository->create($leagueFeature);

        return $leagueFeature;
    }
}
