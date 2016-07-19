<?php

namespace Wooter\Commands\StaticPages;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\ServiceRequest;
use Wooter\Wooter\Exceptions\StaticPages\PackageRequestNotFound;
use Wooter\Wooter\Exceptions\User\UserIsNotAdmin;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\StaticPages\PackageRequestRepository;
use Wooter\Wooter\Repositories\StaticPages\ServiceRequestRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class ReadPackageRequestCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $packageRequestId;


    /**
     * @param $package_request_id
     * @param $user_id
     */
    public function __construct($package_request_id, $user_id)
    {
        $this->userId = $user_id;
        $this->packageRequestId = $package_request_id;
    }

    /**
     * Execute the command.
     *
     * @param PackageRequestRepository $packageRequestRepository
     * @param UserRepository           $userRepository
     *
     * @return ServiceRequest
     * @throws PackageRequestNotFound
     * @throws UserIsNotAdmin
     * @throws UserNotFound
     */
    public function handle(PackageRequestRepository $packageRequestRepository, UserRepository $userRepository)
    {
        $packageRequest = $packageRequestRepository->getById($this->packageRequestId);

        if ( ! $packageRequest) {
            throw new PackageRequestNotFound;
        }

        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        if ( ! $user->isAdmin()) {
            throw new UserIsNotAdmin;
        }

        return $packageRequest;
    }
}
