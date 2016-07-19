<?php

namespace Wooter\Commands\Notifications;

use Illuminate\Contracts\Mail\Mailer;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeagueOrganization;
use Wooter\User;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class SendEmailToPlayerCreatedAndAddedToLeagueCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $view = 'emails.notify-player-created-and-added-to-league';
    /**
     * @var
     */
    private $player;
    /**
     * @var
     */
    private $league;

    /**
     * Create a new command instance.
     *
     * @param User               $player
     * @param LeagueOrganization $league
     */
    public function __construct(User $player, LeagueOrganization $league)
    {
        $this->player = $player;
        $this->league = $league;
    }

    /**
     * Execute the command.
     *
     * @param Mailer $mailer
     *
     * @return bool
     */
    public function handle(Mailer $mailer)
    {
        if ($this->player->beNotifiedViaEmail()) {
            $mailingStrategy = env('MAILING_STRATEGY', 'send');

            $user = $this->player;
            $league = $this->league;

            $mailer->$mailingStrategy($this->view, compact('user', 'league'), function ($mail) use ($user, $league) {
                $mail->to($user->email)->subject($league->name . ' Has Added You to Their League');
            });
        }

        return true;
    }
}
