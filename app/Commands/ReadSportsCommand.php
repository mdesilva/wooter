<?php

namespace Wooter\Commands;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\SportRepository;

class ReadSportsCommand extends Command implements SelfHandling
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
     * Execute the command.
     *
     * @param SportRepository $sportRepository
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function handle(SportRepository $sportRepository)
    {
        return $sportRepository->getAll();
    }
}
