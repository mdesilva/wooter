<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeagueLeagueFeature;
use Wooter\LeaguesLeagueFeature;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueLeagueFeatureRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueFeatureRepository;

class DeleteLeagueFeatureCommand extends Command implements SelfHandling
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
     *
     * @param LeagueFeatureRepository $leagueFeatureRepository
     *
     * @return bool
     * @throws LeagueNotFound
     * @internal param LeagueLeagueFeatureRepository $leagueFeatureRepository
     */
    public function handle(LeagueRepository $leagueRepository, 
                           LeagueFeatureRepository $leagueFeatureRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);
        
        if ( ! $league) {
            throw new LeagueNotFound;
        }

        $leagueFeature = $leagueFeatureRepository->getByLeagueIdAndFeatureId($this->leagueId, $this->featureId);

        if ($leagueFeature) {
            $leagueFeature->delete();
        }

        return true;
    }
}
