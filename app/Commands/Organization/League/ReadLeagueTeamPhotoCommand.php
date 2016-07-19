<?php

namespace Wooter\Commands\Organization\League;

use Illuminate\Support\Facades\DB;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoRepository;


class ReadLeagueTeamPhotoCommand extends Command implements SelfHandling
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
        $this->limit = intval($limit);
        $this->offset = intval($offset);
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle(LeaguePhotoRepository $leaguePhotoRepository)
    {
        $photos = $leaguePhotoRepository->getByLeagueAndTeamId($this->league_id, $this->team_id);
        $photos = ($this->limit >= 0 && $this->offset >= 0) ? $photos->slice($this->offset, $this->limit) : $photos;
        
        return $photos;
    }
}
