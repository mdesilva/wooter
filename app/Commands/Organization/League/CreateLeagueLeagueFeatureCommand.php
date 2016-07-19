<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeagueLeagueFeature;
use Wooter\LeaguesLeagueFeature;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotBelongToUser;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueLeagueFeatureRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\LeagueFeature\LeagueFeatureFeatureRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreateLeagueLeagueFeatureCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueId;
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
    public function __construct($league_id, $league_feature_id, $user_id)
    {
        $this->leagueId = $league_id;
        $this->leagueFeatureId = $league_feature_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueLeagueFeatureRepository $leagueLeagueFeatureRepository
     * @param UserRepository                $userRepository
     * @param LeagueRepository              $leagueRepository
     *
     * @return LeagueLeagueFeature
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws UserNotFound
     * @internal param LeagueLeagueFeatureRepository $leagueFeatureRepository
     */
    public function handle(LeagueLeagueFeatureRepository $leagueLeagueFeatureRepository,
                           UserRepository $userRepository,
                           LeagueRepository $leagueRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);
        if ( ! $league) {
            throw new LeagueNotFound;
        }

        $user = $userRepository->getById($this->userId);

        if (!$user) {
            throw new UserNotFound;
        }

        if ( ! $user->hasOrganization($league->id)) {
            throw new NotPermissionException;
        }

        $leagueLeagueFeature = new LeagueLeagueFeature;
        $leagueLeagueFeature->league_id = $this->leagueId;
        $leagueLeagueFeature->league_feature_id = $this->leagueFeatureId;

        $leagueLeagueFeatureRepository->create($leagueLeagueFeature);

        return $leagueLeagueFeature;
    }
}
