<?php

namespace Wooter\Commands\Player;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Event;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Events\League\NotifyLeagueOwnerPlayerJoinLeagueEvent;
use Wooter\PlayerLeague;
use Wooter\Wooter\Exceptions\Player\PlayerLeagueInvitationNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Player\PlayerLeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Repositories\Organization\League\LeaguePrivateInviteRepository;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerAlreadyJoinedLeague;
use Wooter\Wooter\Exceptions\Player\PlayerAlreadyJoinedTeamAsLeague;

class CreatePlayerLeagueJoinByInviteCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $leagueId;
    /**
     * @var
     */
    private $token;
    /**
     * @var
     */
    private $email;


    /**
     * @param $league_id
     * @param $token
     * @param $email
     */
    public function __construct( $league_id, $token, $email )
    {
        $this->leagueId = $league_id;
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * @param UserRepository                $userRepository
     * @param LeagueRepository              $leagueRepository
     * @param LeaguePrivateInviteRepository $leaguePrivateInviteRepository
     *
     * @return PlayerLeague
     * @throws LeagueNotFound
     * @throws PlayerLeagueInvitationNotFound
     */
    public function handle(UserRepository $userRepository, LeagueRepository $leagueRepository, LeaguePrivateInviteRepository $leaguePrivateInviteRepository)
    {
        $league = $leagueRepository->getById( $this->leagueId );

        if ( ! $league)
        {
            throw new LeagueNotFound;
        }

        $invitation = $leaguePrivateInviteRepository->checkJoinStatus($this->email, $this->token);

        if( ! $invitation )
        {
            throw new PlayerLeagueInvitationNotFound;
        }

        //Update player status to invite
        $invitation->status = 1;
        $leaguePrivateInviteRepository->update($invitation);

        $player = $userRepository->getByEmail( $this->email );

        if ( $player )
        {
            $this->dispatchFromArray(CreatePlayerLeagueCommand::class, ['player_id' => $player->id, 'league_id' => $league->id]);

            Event::fire(new NotifyLeagueOwnerPlayerJoinLeagueEvent($league, $player));

            return true;
        } else {
            return false;
        }

    }
}
