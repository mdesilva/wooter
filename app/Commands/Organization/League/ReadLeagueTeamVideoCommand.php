<?php

namespace Wooter\Commands\Organization\League;

use Illuminate\Support\Facades\DB;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoRepository;


class ReadLeagueTeamVideoCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $league_id;
    /**
     * @var
     */
    private $team_id;
    /**
     * $var
     */
    private $limit;

    /**
     * $var
     */
    private $offset;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($league_id, $team_id, $limit, $offset)
    {
        $this->league_id = $league_id;
        $this->team_id = $team_id;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(LeaguePhotoRepository $leaguePhotoRepository)
    {

         $videos = $leaguePhotoRepository->getTeamVideosByLeagueIdAndPlayerId($this->league_id, $this->team_id, $this->offset, $this->limit);

         return $videos;
    }
}
