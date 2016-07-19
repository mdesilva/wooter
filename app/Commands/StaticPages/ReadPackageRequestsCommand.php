<?php

namespace Wooter\Commands\StaticPages;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\ServiceRequest;
use Wooter\Wooter\Exceptions\User\UserIsNotAdmin;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\StaticPages\PackageRequestRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class ReadPackageRequestsCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $userId;


    /**
     * @param $user_id
     */
    public function __construct($user_id)
    {
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param PackageRequestRepository $packageRequestRepository
     * @param UserRepository           $userRepository
     *
     * @return ServiceRequest
     * @throws UserIsNotAdmin
     * @throws UserNotFound
     */
    public function handle(PackageRequestRepository $packageRequestRepository, UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        if ( ! $user->isAdmin()) {
            throw new UserIsNotAdmin;
        }

        return $packageRequestRepository->getAll();
    }
}
