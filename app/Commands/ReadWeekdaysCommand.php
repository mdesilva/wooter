<?php

namespace Wooter\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\WeekdayRepository;

class ReadWeekdaysCommand extends Command implements SelfHandling
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
     * @param WeekdayRepository $countryRepository
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function handle(WeekdayRepository $countryRepository)
    {
        return $countryRepository->getAll();
    }
}
