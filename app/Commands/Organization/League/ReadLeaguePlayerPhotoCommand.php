<?php

namespace Wooter\Commands\Organization\League;

use Illuminate\Support\Facades\DB;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoRepository;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
class ReadLeaguePlayerPhotoCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $league_id;
    /**
     * @var
     */
    private $player_id;
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
    public function __construct($league_id, $player_id, $limit, $offset)
    {
        $this->league_id = $league_id;
        $this->player_id = $player_id;
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

         $photos = $leaguePhotoRepository->getPlayerPhotosByLeagueIdAndPlayerId($this->league_id, $this->player_id, $this->offset, $this->limit);

         return $photos;
    }
}
