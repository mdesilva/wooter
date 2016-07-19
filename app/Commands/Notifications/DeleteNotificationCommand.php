<?php

namespace Wooter\Commands\Notifications;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\NotificationNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Notification\NotificationRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class DeleteNotificationCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $notificationId;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $notification_id
     */
    public function __construct($user_id, $notification_id)
    {
        $this->userId = $user_id;
        $this->notificationId = $notification_id;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository         $userRepository
     *
     * @param NotificationRepository $notificationRepository
     *
     * @return mixed
     * @throws NotPermissionException
     * @throws NotificationNotFound
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository, NotificationRepository $notificationRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        $notification = $notificationRepository->getById($this->notificationId);

        if ( ! $notification) {
            throw new NotificationNotFound;
        }

        if ($user->id !== $notification->user->id) {
            throw new NotPermissionException;
        }

        return $notificationRepository->deleteById($this->notificationId);
    }
}
