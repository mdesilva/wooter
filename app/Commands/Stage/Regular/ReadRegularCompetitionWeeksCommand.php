<?php

namespace Wooter\Commands\Stage\Regular;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\Stage\Regular\RegularStageNotFound;
use Wooter\Wooter\Repositories\Stage\Regular\RegularCompetitionWeeksRepository;
use Wooter\Wooter\Repositories\Stage\Regular\RegularStageRepository;

class ReadRegularCompetitionWeeksCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $regularId;

    /**
     * Create a new command instance.
     *
     * @param $regular_id
     */
    public function __construct($regular_id)
    {
        $this->regularId = $regular_id;
    }

    /**
     * Execute the command.
     *
     * @param RegularStageRepository            $RegularStageRepository
     *
     * @param RegularCompetitionWeeksRepository $regularCompetitionWeeksRepository
     *
     * @return
     * @throws RegularStageNotFound
     */
    public function handle(RegularStageRepository $RegularStageRepository, RegularCompetitionWeeksRepository $regularCompetitionWeeksRepository)
    {
        $regular = $RegularStageRepository->getById($this->regularId);

        if ( ! $regular) {
            throw new RegularStageNotFound;
        }

        return $regularCompetitionWeeksRepository->getByRegularId($this->regularId);
    }
}

