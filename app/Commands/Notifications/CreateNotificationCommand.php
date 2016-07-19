<?php

namespace Wooter\Commands\Notifications;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Notification;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Notification\NotificationRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreateNotificationCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $userId;
    /**
     * @var
     */
    private $title;
    /**
     * @var
     */
    private $text;
    /**
     * @var
     */
    private $eventType;
    /**
     * @var null
     */
    private $image;

    /**
     * Create a new command instance.
     *
     * @param      $user_id
     * @param      $title
     * @param      $text
     * @param      $event_type
     * @param null $image
     */
    public function __construct($user_id, $title, $text, $event_type = null, $image = null)
    {
        $this->userId = $user_id;
        $this->title = $title;
        $this->text = $text;
        $this->eventType = $event_type;
        $this->image = $image;
    }

    /**
     * Execute the command.
     *
     * @param UserRepository         $userRepository
     * @param NotificationRepository $notificationRepository
     *
     * @return $this|null
     * @throws UserNotFound
     */
    public function handle(UserRepository $userRepository, NotificationRepository $notificationRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user) {
            throw new UserNotFound;
        }

        $notification = new Notification;

        $notification->title = $this->title;
        $notification->text = $this->text;
        $notification->user_id = $user->id;
        $notification->consumed = false;

        if (is_null($this->eventType)) {
            $notification->event_type = Notification::TYPE_BASIC_NOTIFICATION;
        } else {
            $notification->event_type = $this->eventType;
        }

        if ( ! is_null($this->image)) {
            //todo: Add image
        }

        $notificationRepository->create($notification);

        return $notification->fresh();
    }
}
