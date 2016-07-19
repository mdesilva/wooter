<?php

namespace Wooter\Commands\Player;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeagueOrganization;
use Illuminate\Contracts\Mail\Mailer as MailerContract;
use Illuminate\Mail\Message;
use Wooter\User;

class NotifyPlayerRequestedToJoinLeagueCommand extends Command implements SelfHandling
{
    const NOTIFY_PLAYER_REQUESTED_JOIN_LEAGUE_VIEW = 'emails.notify-player-requested-to-join-league';

    /**
     * @var User
     */
    private $email;

    /**
     * @var League
     */
    private $league;

    /**
     * @var
     */
    private $token;

    /**
     * @param League $league
     * @param        $email
     * @param        $token
     *
     */
    public function __construct(League $league, $email, $token)
    {
        $this->email = $email;
        $this->league = $league;
        $this->token = $token;
    }

    /**
     * @param MailerContract $mailer
     * @return bool
     */
    public function handle(MailerContract $mailer)
    {
        $email = $this->email;
        $league = $this->league;
        $token = $this->token;

        $mailer->send(self::NOTIFY_PLAYER_REQUESTED_JOIN_LEAGUE_VIEW, compact('email','league','token'), function (Message $message) use ($email, $league) {
            $message->to($email);
            $message->subject('Hello from Wooter! You have been invited to join ' . $league->name);
        });

        return true;
    }
}
