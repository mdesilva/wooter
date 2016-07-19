<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Player\AwardNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerAwardNotFound;
use Wooter\Wooter\Exceptions\Player\PlayerNotFound;
use Wooter\Wooter\Repositories\Player\AwardRepository;
use Wooter\Wooter\Repositories\Player\PlayerAwardRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class UpdatePlayerAwardCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $playerAwardId;
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
     *
     * @param $player_award_id
     * @param $player_id
     * @param $award_id
     */
    public function __construct($player_award_id, $player_id, $award_id)
    {
        $this->playerAwardId = $player_award_id;
        $this->playerId = $player_id;
        $this->awardId = $award_id;
    }

    /**
     * Execute the command.
     *
     * @param PlayerAwardRepository $playerAwardRepository
     * @param AwardRepository $awardRepository
     * @param UserRepository $userRepository
     * @throws AwardNotFound
     * @throws PlayerAwardNotFound
     * @throws PlayerNotFound
     */
    public function handle(PlayerAwardRepository $playerAwardRepository, AwardRepository $awardRepository, UserRepository $userRepository)
    {
        $playerAward = $playerAwardRepository->getById($this->playerAwardId);

        if ( ! $playerAward)
        {
            throw new PlayerAwardNotFound;
        }

        $award = $awardRepository->getById($this->awardId);

        if ( ! $award)
        {
            throw new AwardNotFound;
        }

        $player = $userRepository->getById($this->playerId);

        if ( ! $player)
        {
            throw new PlayerNotFound;
        }

        $playerAward->award_id = $this->awardId;
        $playerAward->player_id = $this->playerId;

        $playerAwardRepository->update($playerAward);

        return $playerAward;
    }
}
