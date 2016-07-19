<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Competition\Season\SeasonCompetitionNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Repositories\Competition\Season\SeasonCompetitionsRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueSeasonRepository;

class ReadLeagueSeasonCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueId;
    
    /**
     * @var
     */
    private $seasonId;
    
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $user_id
     * @param $league_id
     * @param $season_id
     */
    public function __construct($user_id, $league_id, $season_id)
    {
        $this->userId = $user_id;
        $this->leagueId = $league_id;
        $this->seasonId = $season_id;
    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository             $leagueRepository
     * @param SeasonCompetitionsRepository $seasonCompetitionsRepository
     *
     * @return
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws SeasonCompetitionNotFound
     */
    public function handle(LeagueRepository $leagueRepository, SeasonCompetitionsRepository $seasonCompetitionsRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }
        $season = $seasonCompetitionsRepository->getById($this->seasonId);

        if ( ! $season) {
            throw new SeasonCompetitionNotFound;
        }

        if ($season->organization->id != $league->id) {
            throw new NotPermissionException;
        }

        return $season;
    }   
}
