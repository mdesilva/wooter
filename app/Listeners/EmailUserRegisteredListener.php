<?php

namespace Wooter\Listeners;

use Wooter\Events\UserWasRegisteredEvent;
use Wooter\Wooter\Facades\VerifyUser;
use Illuminate\Mail\Message;

class EmailUserRegisteredListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param UserWasRegisteredEvent $event
     */
    public function handle(UserWasRegisteredEvent $event)
    {
        $user = $event->user;

        VerifyUser::sendVerifyUserLink(['email' => $user->email], function (Message $message) {
            $message->subject($this->getEmailSubject());
        });

    }

    /**
     * Get the e-mail subject line to be used for the reset link email.
     *
     * @return string
     */
    protected function getEmailSubject()
    {
        return property_exists($this, 'subject') ? $this->subject : 'Your verify account link';
    }
}
