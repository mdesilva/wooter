<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Organization\League\LeaguePhotoRepository;

class ReadLeagueGamePhotoCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $league_id;
    /**
     * @var
     */
    private $game_id;
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
    public function __construct($league_id, $game_id, $limit, $offset)
    {
        $this->league_id = $league_id;
        $this->game_id = $game_id;
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
        $photos = [];
        $photos = $leaguePhotoRepository->getPhotoByGameAndLeagueId($this->league_id, $this->game_id, $this->offset, $this->limit);
        return $photos;
    }
}
