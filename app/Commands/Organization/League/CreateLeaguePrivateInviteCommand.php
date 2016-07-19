<?php

namespace Wooter\Commands\Organization\League;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Wooter\Commands\Player\NotifyPlayerRequestedToJoinLeagueCommand;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\LeaguePrivateInvite;
use Wooter\Wooter\Repositories\Organization\League\LeaguePrivateInviteRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeaguePlayerAlreadyInvited;


class CreateLeaguePrivateInviteCommand extends Command implements SelfHandling
{
    use DispatchesJobs;

    /**
     * @var
     */
    private $leagueId;

    /**
     * @var
     */
    private $email;


    /**
     * @param $league_id
     * @param $email
     */
    public function __construct($league_id, $email)
    {
        $this->leagueId = $league_id;
        $this->email = $email;
    }

    /**
     * @param LeaguePrivateInviteRepository $leaguePrivateInviteRepository
     * @param LeagueRepository $leagueRepository
     * @return bool
     * @throws LeagueNotFound
     * @throws LeaguePlayerAlreadyInvited
     */
    public function handle(LeaguePrivateInviteRepository $leaguePrivateInviteRepository,  LeagueRepository $leagueRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        //Check if user being invited is already invited for the league
        $checkLeagueInvites = $leaguePrivateInviteRepository->getInvited($this->email);
        if( $checkLeagueInvites )
        {
            throw new LeaguePlayerAlreadyInvited;
        }

        // Create League join passcode tokens
        $token = uniqid("", false);
        $leaguePrivateInvite = new LeaguePrivateInvite;
        $leaguePrivateInvite->league_id = $this->leagueId;
        $leaguePrivateInvite->email = $this->email;
        $leaguePrivateInvite->token = $token;
        $data = $leaguePrivateInviteRepository->create($leaguePrivateInvite);

        // Notify player by mail
        $this->dispatchFromArray(NotifyPlayerRequestedToJoinLeagueCommand::class, ['league' => $league, 'email' => $this->email,  'token' => $token]);

        return true;
     }
}
