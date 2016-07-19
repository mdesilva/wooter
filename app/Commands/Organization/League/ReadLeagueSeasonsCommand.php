<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Http\Controllers\API\ApiController;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;

class ReadLeagueSeasonsCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $leagueId;
    
    /**
     * @var
     */
    private $offset;
    
    /**
     * @var
     */
    private $limit;

    /**
     * ReadLeagueSeasonsCommand constructor.
     *
     * @param $league_id
     * @param $offset
     * @param $limit
     */
    public function __construct($league_id, $offset = ApiController::DEFAULT_OFFSET, $limit = ApiController::DEFAULT_LIMIT)
    {
        $this->leagueId = $league_id;
        $this->offset = $offset;
        $this->limit = $limit;

    }

    /**
     * Execute the command.
     *
     * @param LeagueRepository $leagueRepository
     *
     * @return mixed
     * @throws LeagueNotFound
     * @internal param UserRepository $use rRepository* rRepository
     */
    public function handle(LeagueRepository $leagueRepository)
    {
        $league = $leagueRepository->getById($this->leagueId);
        
        if (!$league) {
            throw new LeagueNotFound();
        }

        $seasons = $league->seasons;

        return $seasons->slice($this->offset, $this->limit);
    }
}
