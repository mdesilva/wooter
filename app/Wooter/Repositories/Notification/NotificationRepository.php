<?php

namespace Wooter\Wooter\Repositories\Notification;

use DB;
use Wooter\Notification;
use Wooter\UserRole;
use Wooter\Role;
use Wooter\User;

class NotificationRepository
{

    /**
     * @param Notification $notification
     *
     * @return bool
     */
    public function create(Notification $notification)
    {
        return $notification->push();
    }

    /**
     * @param Notification $notification
     *
     * @return bool
     */
    public function update(Notification $notification)
    {
        return $notification->push();
    }

    /**
     * @param $notificationId
     *
     * @return mixed
     */
    public function getById($notificationId)
    {
        return Notification::whereId($notificationId)->get();
    }

    /**
     * @param $userId
     *
     * @return mixed
     */
    public function getByUserId($userId)
    {
        return Notification::whereUserId($userId)->get();
    }

    /**
     * @param $userId
     *
     * @return mixed
     */
    public function getPendingByUserId($userId)
    {
        return Notification::whereUserId($userId)->whereConsumed(false)->get();
    }

    /**
     * @param $userId
     *
     * @return mixed
     */
    public function deleteByUserId($userId)
    {
        return Notification::whereUserId($userId)->delete();
    }

    /**
     * @param $notificationId
     *
     * @return mixed
     */
    public function deleteById($notificationId)
    {
        return Notification::whereId($notificationId)->delete();
    }

    /**
     * @param $userId
     *
     * @return mixed
     */
    public function markAsConsumedByUserId($userId)
    {
        return Notification::whereUserId($userId)->delete();
    }
}
