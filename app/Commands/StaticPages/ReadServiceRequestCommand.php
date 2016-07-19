<?php

namespace Wooter\Commands\StaticPages;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\ServiceRequest;
use Wooter\Wooter\Exceptions\StaticPages\ServiceRequestNotFound;
use Wooter\Wooter\Exceptions\User\UserIsNotAdmin;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\StaticPages\ServiceRequestRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class ReadServiceRequestCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $serviceRequestId;


    /**
     * @param $service_request_id
     * @param $user_id
     */
    public function __construct($service_request_id, $user_id)
    {
        $this->userId = $user_id;
        $this->serviceRequestId = $service_request_id;
    }

    /**
     * Execute the command.
     *
     * @param ServiceRequestRepository $serviceRequestRepository
     *
     * @param UserRepository           $userRepository
     *
     * @return ServiceRequest
     * @throws ServiceRequestNotFound
     * @throws UserIsNotAdmin
     * @throws UserNotFound
     */
    public function handle(ServiceRequestRepository $serviceRequestRepository, UserRepository $userRepository)
    {
        $serviceRequest = $serviceRequestRepository->getById($this->serviceRequestId);

        if ( ! $serviceRequest) {
            throw new ServiceRequestNotFound;
        }

        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        if ( ! $user->isAdmin()) {
            throw new UserIsNotAdmin;
        }

        return $serviceRequest;
    }
}
