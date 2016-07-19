<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\PlayerLeague;
use Wooter\Wooter\Exceptions\Organization\League\LeagueNotFound;
use Wooter\Wooter\Exceptions\NotPermissionException;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Repositories\Organization\League\LeagueRepository;
use Wooter\Wooter\Repositories\Player\PlayerLeagueRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreatePlayerLeagueCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $playerId;
    /**
     * @var
     */
    private $leagueId;

    /**
     * Create a new command instance.
     *
     * @param $player_id
     * @param $league_id
     */
    public function __construct($player_id, $league_id)
    {
        $this->playerId = $player_id;
        $this->leagueId = $league_id;
    }

    /**
     * Execute the command.
     *
     * @param PlayerLeagueRepository $playerLeagueRepository
     * @param UserRepository         $userRepository
     * @param LeagueRepository       $leagueRepository
     *
     * @return PlayerLeague
     * @throws LeagueNotFound
     * @throws NotPermissionException
     * @throws PlayerNotFound
     */
    public function handle(PlayerLeagueRepository $playerLeagueRepository, UserRepository $userRepository, LeagueRepository $leagueRepository)
    {
        $playerLeague = $playerLeagueRepository->getByPlayerAndLeagueId($this->playerId, $this->leagueId);

        if ($playerLeague) {
            return $playerLeague;
        }

        $player = $userRepository->getById($this->playerId);

        if ( ! $player) {
            throw new PlayerNotFound;
        }

        $league = $leagueRepository->getById($this->leagueId);

        if ( ! $league) {
            throw new LeagueNotFound;
        }

        $playerLeague = new PlayerLeague;

        $playerLeague->player_id = $this->playerId;
        $playerLeague->league_id = $this->leagueId;

        $playerLeagueRepository->create($playerLeague);

        return $playerLeague;
    }
}
