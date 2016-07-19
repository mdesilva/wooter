<?php

namespace Wooter\Commands\Team;

use Illuminate\Support\Facades\Route;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;

class ReadTeamsCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $userId;

    /**
     * @var 
     */
    private $player_id;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $player_id
     */
    public function __construct($user_id, $player_id)
    {
        $this->userId = $user_id;
        $this->player_id = $player_id;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository $userRepository
     *
     * @return mixed
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        if ($this->player_id) {
            $user = $userRepository->getById($this->player_id);
            return $user->teams;
        }

        return $user->teams;

    }
}

