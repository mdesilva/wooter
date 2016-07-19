<?php

namespace Wooter\Listeners\Email;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\View\View;
use Mockery\CountValidator\Exception;
use Wooter\Events\Email\StaticFormSubmissionEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class StaticFormSubmissionListener
{
     /**
     * @var Mailer
     */
    private $mailer;

     /**
     * @var View
     */
    private $view = 'emails.static_form_submission';

    /**
     * Create the event listener.
     *
     *
     * @param $mailer
     */
    public function __construct()
    {
        // $this->mailer = $mailer;
    }
    /**
     * Handle the event.
     *
     * @param StaticFormSubmissionEvent|StaticFormSubmissionEvent $event
     */
    public function handle(StaticFormSubmissionEvent $event)
    {
        Mail::send($this->view, compact('event'), function ($message) use ($event) {
            $message->to("vip@wooter.co");
            $message->subject($event->array->subject);
        });
    }
}
