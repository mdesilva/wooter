<?php

namespace Wooter\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\GameStructureRepository;

class ReadGameStructuresCommand extends Command implements SelfHandling
{
    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
    }

    /**
     * @param GameStructureRepository $gameStructureRepository
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function handle(GameStructureRepository $gameStructureRepository)
    {
        return $gameStructureRepository->getAll();
    }
}
