<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueVideoLabelRepository;

class ReadLeagueVideoLabelsCommand extends Command implements SelfHandling
{
    private $leagueId;
    private $userId;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($user_id, $league_id)
    {
        $this->leagueId = $league_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(LeagueRepository $leagueRepository, LeagueVideoLabelRepository $leagueVideoLabelRepository)
    {
        //check league
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound();
        }


        $labels = $leagueVideoLabelRepository->getFromLeagueId($this->leagueId);

        return $labels;

    }
}
