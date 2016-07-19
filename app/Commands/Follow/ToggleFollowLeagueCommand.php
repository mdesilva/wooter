<?php

namespace Wooter\Commands\Follow;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\FollowLeague;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Follow\FollowLeagueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class ToggleFollowLeagueCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $userId;
    /**
     * @var null
     */
    private $status;

    /**
     * Create a new command instance.
     *
     * @param      $league_id
     * @param      $user_id
     * @param null $status
     */
    public function __construct($league_id, $user_id, $status = null)
    {
        $this->leagueId = $league_id;
        $this->userId = $user_id;
        $this->status = $status;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository       $leagueRepository
     * @param UserRepository         $userRepository
     *
     * @param FollowLeagueRepository $followLeagueRepository
     *
     * @return FollowLeague
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
            $followLeague = new FollowLeague;

            $followLeague->league_id = $this->leagueId;
            $followLeague->user_id = $this->userId;
            $followLeague->status = FollowLeague::FOLLOWING;
        } else {
            if ((int)$followLeague->status === FollowLeague::FOLLOWING) {
                $followLeague->status = FollowLeague::UNFOLLOWING;
            } else {
                $followLeague->status = FollowLeague::FOLLOWING;
            }
        }

        if ($this->status) { // In force case
            $followLeague->status = $this->status;
        }

        $followLeagueRepository->create($followLeague);

        return $followLeague;
    }
}
