<?php

namespace Wooter\Listeners;

use Illuminate\Contracts\Mail\Mailer;
use Mockery\CountValidator\Exception;
use Wooter\Events\SuccessfulRegistration;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailSuccessfulRegistration
{
    /**
     * @var Mailer
     */
    private $mailer;

    protected $view = 'emails.successful_registration';

    /**
     * Create the event listener.
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  SuccessfulRegistration  $event
     * @return void
     */
    public function handle(SuccessfulRegistration $event)
    {
        $user = $event->user;

        $this->mailer->send($this->view, compact('user'), function ($message) use ($user) {
            $message->to($user->email);
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
        return property_exists($this, 'subject') ? $this->subject : 'You have been successfully registered at Wooter!';
    }
}
