<?php

namespace Wooter\Commands\Team;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Team\TeamNotFound;
use Wooter\Wooter\Repositories\Team\TeamRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;

class ReadTeamCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $userId;
    
    /**
     * @var 
     */
    private $teamId;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $team_id
     */
    public function __construct($user_id, $team_id)
    {
        $this->userId = $user_id;
        $this->teamId = $team_id;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $userRepository
     * @param TeamRepository $teamRepository
     *
     * @return
     * @throws TeamNotFound
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository, TeamRepository $teamRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        $team = $teamRepository->getById($this->teamId);

        if ( ! $team) {
            throw new TeamNotFound;
        }
        
        return $team;
    }
}