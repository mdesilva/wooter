<?php

namespace Wooter\Commands\Player;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Player\StatNotFound;
use Wooter\Wooter\Repositories\Player\StatRepository;

class UpdateStatCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $statId;
    /**
     * @var
     */
    private $pointsScored;
    /**
     * @var
     */
    private $metric;

    /**
     * Create a new command instance.
     *
     * @param $stat_id
     * @param $metric
     * @param $points_scored
     */
    public function __construct($stat_id, $metric, $points_scored)
    {
        $this->statId = $stat_id;
        $this->pointsScored = $points_scored;
        $this->metric = $metric;
    }

    /**
     * Execute the command.
     * @param StatRepository $statRepository
     * @return
     * @throws StatNotFound
     */
    public function handle(StatRepository $statRepository)
    {
        $stat = $statRepository->getById($this->statId);

        if ( ! $stat)
        {
            throw new StatNotFound;
        }

        $stat->metric = $this->metric;
        $stat->points_scored = $this->pointsScored;

        $statRepository->update($stat);

        return $stat;
    }
}
