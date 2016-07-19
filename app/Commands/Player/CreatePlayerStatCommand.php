<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\PlayerStat;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Exceptions\Player\StatNotFound;
use Wooter\Wooter\Repositories\Player\PlayerStatRepository;
use Wooter\Wooter\Repositories\Player\StatRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreatePlayerStatCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $playerId;
    /**
     * @var
     */
    private $statId;

    /**
     * Create a new command instance.
     * @param $player_id
     * @param $stat_id
     * @internal param $league_id
     */
    public function __construct($player_id, $stat_id)
    {
        $this->playerId = $player_id;
        $this->statId = $stat_id;
    }

    /**
     * Execute the command.
     *
     * @param PlayerStatRepository $playerStatRepository
     * @param UserRepository $userRepository
     * @param StatRepository $statRepository
     * @return PlayerStat
     * @throws StatNotFound
     * @throws PlayerNotFound
     * @internal param StatRepository $leagueRepository
     */
    public function handle(PlayerStatRepository $playerStatRepository, UserRepository $userRepository, StatRepository $statRepository)
    {
        $stat = $statRepository->getById($this->statId);

        if ( ! $stat)
        {
            throw new StatNotFound;
        }

        $player = $userRepository->getById($this->playerId);

        if ( ! $player)
        {
            throw new PlayerNotFound;
        }

        $playerStat = new PlayerStat();

        $playerStat->player_id = $this->playerId;
        $playerStat->stat_id = $this->statId;

        $playerStatRepository->create($playerStat);

        return $playerStat;
    }
}
