<?php

namespace Wooter\Commands\Notifications;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Notification\NotificationRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class DeleteNotificationsCommand extends Command implements SelfHandling
{
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
     *
     * @param NotificationRepository $notificationRepository
     *
     * @return mixed
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository, NotificationRepository $notificationRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        return $notificationRepository->deleteByUserId($this->userId);
    }
}
