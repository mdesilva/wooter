<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Player\StatNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerStatNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Repositories\Player\PlayerStatRepository;
use Wooter\Wooter\Repositories\Player\StatRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class UpdatePlayerStatCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $playerStatId;
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
     *
     * @param $player_stat_id
     * @param $player_id
     * @param $stat_id
     */
    public function __construct($player_stat_id, $player_id, $stat_id)
    {
        $this->playerStatId = $player_stat_id;
        $this->playerId = $player_id;
        $this->statId = $stat_id;
    }

    /**
     * Execute the command.
     *
     * @param PlayerStatRepository $playerStatRepository
     * @param StatRepository $statRepository
     * @param UserRepository $userRepository
     * @throws StatNotFound
     * @throws PlayerStatNotFound
     * @throws PlayerNotFound
     */
    public function handle(PlayerStatRepository $playerStatRepository, StatRepository $statRepository, UserRepository $userRepository)
    {
        $playerStat = $playerStatRepository->getById($this->playerStatId);

        if ( ! $playerStat)
        {
            throw new PlayerStatNotFound;
        }

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

        $playerStat->stat_id = $this->statId;
        $playerStat->player_id = $this->playerId;

        $playerStatRepository->update($playerStat);

        return $playerStat;
    }
}
