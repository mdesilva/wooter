<?php

namespace Wooter\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\SeasonStructureRepository;

class ReadSeasonStructuresCommand extends Command implements SelfHandling
{
    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * @param SeasonStructureRepository $seasonStructureRepository
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function handle(SeasonStructureRepository $seasonStructureRepository)
    {
        return $seasonStructureRepository->getAll();
    }
}
