<?php

namespace Wooter\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\PlayoffStructureRepository;

class ReadPlayoffStructuresCommand extends Command implements SelfHandling
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
     * @param PlayoffStructureRepository $playoffStructureRepository
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function handle(PlayoffStructureRepository $playoffStructureRepository)
    {
        return $playoffStructureRepository->getAll();
    }
}
