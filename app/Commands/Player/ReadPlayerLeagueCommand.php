<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Player\PlayerLeagueNotFound;
use Wooter\Wooter\Repositories\Player\PlayerLeagueRepository;

class ReadPlayerLeagueCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $playerLeagueId;

    /**
     * Create a new command instance.
     *
     * @param $player_league_id
     */
    public function __construct($player_league_id)
    {
        $this->playerLeagueId = $player_league_id;
    }

    /**
     * Execute the command.
     *
     * @param PlayerLeagueRepository $playerLeagueRepository
     *
     * @return
     * @throws PlayerLeagueNotFound
     */
    public function handle(PlayerLeagueRepository $playerLeagueRepository)
    {
        $playerLeague = $playerLeagueRepository->getById($this->playerLeagueId);

        if ( ! $playerLeague) {
            throw new PlayerLeagueNotFound;
        }

        return $playerLeague;
    }
}
