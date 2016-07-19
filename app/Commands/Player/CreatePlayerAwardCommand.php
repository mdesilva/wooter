<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\PlayerAward;
use Wooter\Wooter\Exceptions\Player\AwardNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Repositories\Player\AwardRepository;
use Wooter\Wooter\Repositories\Player\PlayerAwardRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreatePlayerAwardCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $playerId;
    /**
     * @var
     */
    private $awardId;

    /**
     * Create a new command instance.
     * @param $player_id
     * @param $award_id
     */
    public function __construct($player_id, $award_id)
    {
        $this->playerId = $player_id;
        $this->awardId = $award_id;
    }

    /**
     * Execute the command.
     *
     * @param PlayerAwardRepository $playerAwardRepository
     * @param UserRepository $userRepository
     * @param AwardRepository $awardRepository
     * @return PlayerAward
     * @throws AwardNotFound
     * @throws PlayerNotFound
     */
    public function handle(PlayerAwardRepository $playerAwardRepository, UserRepository $userRepository, AwardRepository $awardRepository)
    {
        $player = $userRepository->getById($this->playerId);

        if ( ! $player)
        {
            throw new PlayerNotFound;
        }

        $award = $awardRepository->getById($this->awardId);

        if ( ! $award)
        {
            throw new AwardNotFound;
        }

        $playerAward = new PlayerAward;

        $playerAward->player_id = $this->playerId;
        $playerAward->award_id = $this->awardId;

        $playerAwardRepository->create($playerAward);

        return $playerAward;
    }
}
