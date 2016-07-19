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

class ReadFollowLeaguesCommand extends Command implements SelfHandling
{
    use DispatchesJobs;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     */
    public function __construct($user_id)
    {
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository         $userRepository
     * @param FollowLeagueRepository $followLeagueRepository
     *
     * @return array
     * @throws LeagueNotFound
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository, FollowLeagueRepository $followLeagueRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        return $followLeagueRepository->getFollowingByUserId($this->userId);
    }
}
