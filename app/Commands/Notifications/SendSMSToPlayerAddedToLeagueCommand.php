<?php

namespace Wooter\Commands\Notifications;

use Aloha\Twilio\Manager as Twilio;;
use Illuminate\Contracts\Queue\ShouldQueue;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeagueOrganization;
use Wooter\User;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\User\UserRepository;

class SendSMSToPlayerAddedToLeagueCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $message = "%s has added you to their league via http://wooter.co Login through the app to see your player profile.";
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
     *
     */
    public function __construct(User $player, LeagueOrganization $league)
    {
        $this->player = $player;
        $this->league = $league;
    }
    /**
     * Execute the command.
     *
     * @param Twilio         $twilio
     *
     * @return bool
     * @throws PlayerNotFound
     */
    public function handle(Twilio $twilio)
    {

        if (env('TWILIO_SEND_SMS_ENABLED', false)) {
            $twilio->from('twilio')->message($this->player->phone, sprintf($this->message, $this->league->name));
        }

        return true;
    }
}
