<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Award;
use Wooter\Wooter\Exceptions\User\UserIsNotAdmin;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Player\AwardRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreateAwardCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $name;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $name
     */
    public function __construct($user_id, $name)
    {
        $this->userId = $user_id;
        $this->name = $name;
    }

    /**
     * Execute the command.
     *
     * @param AwardRepository $awardRepository
     * @param UserRepository  $userRepository
     *
     * @return Award
     * @throws UserIsNotAdmin
     * @throws UserNotFound
     */
    public function handle(AwardRepository $awardRepository, UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user)
        {
            throw new UserNotFound;
        }

        if ( ! $user->isAdmin()) {
            throw new UserIsNotAdmin;
        }

        $award = new Award;
        $award->name = $this->name;

        $awardRepository->create($award);

        return $award;
    }
}
