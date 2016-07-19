<?php

namespace Wooter\Commands\Player;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Team;
use Wooter\User;
use Illuminate\Contracts\Mail\Mailer as MailerContract;
use Illuminate\Mail\Message;

class NotifyPlayerAddedToTeamCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    const NOTIFY_PLAYER_ADDED_TO_TEAM_VIEW = 'emails.notify-player-added-to-team';

    /**
     * @var User
     */
    private $player;
    /**
     * @var Team
     */
    private $team;

    /**
     * @param User   $player
     * @param Team $team
     */
    public function __construct(User $player, Team $team)
    {
        $this->player = $player;
        $this->team = $team;
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
        $team = $this->team;
        
        $mailer->send(self::NOTIFY_PLAYER_ADDED_TO_TEAM_VIEW, compact('player', 'team'), function (Message $message) use ($player, $team) {
            $message->to($player->email);
            $message->subject("You have been added to the team: {$team->name}, at Wooter.");
        });
        
        

        return true;
    }
}
