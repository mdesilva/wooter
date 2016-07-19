<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeagueOrganization;
use Wooter\User;
use Wooter\Wooter\Facades\UserToken;
use Wooter\Wooter\Repositories\User\UserRepository;
use Illuminate\Contracts\Mail\Mailer as MailerContract;
use Illuminate\Mail\Message;

class NotifyPlayerAddedToLeagueCommand extends Command implements SelfHandling
{
    const NOTIFY_PLAYER_ADDED_TO_LEAGUE_VIEW = 'emails.notify-player-added-to-league';

    /**
     * @var User
     */
    private $player;
    /**
     * @var League
     */
    private $league;

    /**
     * @param User   $player
     * @param League $league
     */
    public function __construct(User $player, League $league)
    {
        $this->player = $player;
        $this->league = $league;
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
        $league = $this->league;

        $mailer->send(self::NOTIFY_PLAYER_ADDED_TO_LEAGUE_VIEW, compact('player', 'league'), function (Message $message) use ($player) {
            $message->to($player->email);
            $message->subject('You have been added to league in Wooter');
        });

        return true;
    }
}
