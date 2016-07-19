<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Player\AwardNotFound;
use Wooter\Wooter\Repositories\Player\AwardRepository;

class UpdateAwardCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $awardId;
    /**
     * @var
     */
    private $name;

    /**
     * Create a new command instance.
     *
     * @param $award_id
     * @param $name
     */
    public function __construct($award_id, $name)
    {
        $this->awardId = $award_id;
        $this->name = $name;
    }

    /**
     * Execute the command.
     * @param AwardRepository $awardRepository
     * @return
     * @throws AwardNotFound
     */
    public function handle(AwardRepository $awardRepository)
    {
        $award = $awardRepository->getById($this->awardId);

        if ( ! $award)
        {
            throw new AwardNotFound;
        }

        $award->name = $this->name;

        $awardRepository->update($award);

        return $award;
    }
}
