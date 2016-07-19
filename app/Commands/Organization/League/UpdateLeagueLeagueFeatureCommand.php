<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Organization\League\LeagueLeagueFeatureRepository;

class UpdateLeagueLeagueFeatureCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueFeatureId;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $league_id
     * @param $league_feature_id
     * @param $user_id
     */
    public function __construct($league_feature_id, $user_id)
    {
        $this->leagueFeatureId = $league_feature_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     */
    public function handle(LeagueLeagueFeatureRepository $leagueLeagueFeatureRepository)
    {
        $leaguePhoto = $leagueLeagueFeatureRepository->getById($this->leaguePhotoId);

        if ( ! $leaguePhoto)
        {
            throw new LeaguePhotoNotFound;
        }

        if ($leaguePhoto->league->organization->user->id !== $this->userId) {
            throw new LeagueNotBelongToUser;
        }

        $leaguePhoto->name = $this->name;
        $leaguePhoto->source = $this->source;

        $leaguePhotoRepository->update($leaguePhoto);

        return $leaguePhoto;
    }
}
