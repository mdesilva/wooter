<?php

namespace Wooter\Commands\Player;

use Wooter\Stat;
use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\Player\StatRepository;

class CreateStatCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $metric;
    /**
     * @var
     */
    private $pointsScored;

    /**
     * Create a new command instance.
     * @param $metric
     * @param $points_scored
     */
    public function __construct($metric, $points_scored)
    {
        $this->metric = $metric;
        $this->pointsScored = $points_scored;
    }

    /**
     * Execute the command.
     *
     * @param StatRepository $statRepository
     * @return Stat
     */
    public function handle(StatRepository $statRepository)
    {
        $stat = new Stat;

        $stat->metric = $this->metric;
        $stat->points_scored = $this->pointsScored;

        $statRepository->create($stat);

        return $stat;
    }
}
