<?php

namespace Wooter\Commands\Follow;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\FollowLeague;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Follow\FollowLeagueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class ReadFollowLeagueCommand extends Command implements SelfHandling
{
    use DispatchesJobs;
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $league_id
     * @param $user_id
     */
    public function __construct($league_id, $user_id)
    {
        $this->leagueId = $league_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository       $leagueRepository
     * @param UserRepository         $userRepository
     * @param FollowLeagueRepository $followLeagueRepository
     *
     * @return array
     * @throws LeagueNotFound
     * @throws UserNotFound
     */
    public function handle(LeagueRepository $leagueRepository, UserRepository $userRepository, FollowLeagueRepository $followLeagueRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        $followLeague = $followLeagueRepository->getByLeagueIdAndUserId($this->leagueId, $this->userId);

        if ( ! $followLeague) {
            $followLeague = $this->dispatchFromArray(ToggleFollowLeagueCommand::class, ['league_id' => $this->leagueId, 'user_id' => $this->userId, 'status' => FollowLeague::UNFOLLOWING]);
        }

        return $followLeague;
    }
}
