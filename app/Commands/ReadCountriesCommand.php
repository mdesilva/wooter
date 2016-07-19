<?php

namespace Wooter\Commands;

use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\CountryRepository;

class ReadCountriesCommand extends Command implements SelfHandling
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
     * @param CountryRepository $countryRepository
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function handle(CountryRepository $countryRepository)
    {
        return $countryRepository->getAll();
    }
}
