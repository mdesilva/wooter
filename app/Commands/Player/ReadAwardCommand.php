<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Player\AwardNotFound;
use Wooter\Wooter\Exceptions\User\UserIsNotAdmin;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Player\AwardRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class ReadAwardCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $awardId;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $award_id
     * @param $user_id
     */
    public function __construct($award_id, $user_id)
    {
        $this->awardId = $award_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param AwardRepository $awardRepository
     *
     * @param UserRepository  $userRepository
     *
     * @return
     * @throws AwardNotFound
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

        $award = $awardRepository->getById($this->awardId);

        if ( ! $award) {
            throw new AwardNotFound;
        }


        return $award;
    }
}
