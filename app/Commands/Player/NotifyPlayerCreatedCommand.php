<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\User;
use Wooter\Wooter\Facades\UserToken;
use Illuminate\Contracts\Mail\Mailer as MailerContract;
use Illuminate\Mail\Message;

class NotifyPlayerCreatedCommand extends Command implements SelfHandling
{

    const NOTIFY_PLAYER_CREATED_VIEW = 'emails.notify-player-created';

    /**
     * @var User
     */
    private $player;

    /**
     * @param User $player
     */
    public function __construct(User $player)
    {
        $this->player = $player;
    }

    /**
     * Execute the command.
     *
     * @param MailerContract $mailer
     *
     * @return User
     */
    public function handle(MailerContract $mailer)
    {


        $player = $this->player;

        $token = UserToken::create($player);

        $mailer->send(self::NOTIFY_PLAYER_CREATED_VIEW, compact('player', 'token'), function (Message $message) use ($player) {
            $message->to($player->email);
            $message->subject('You have been added to Wooter');

        });

        return true;
    }
}
