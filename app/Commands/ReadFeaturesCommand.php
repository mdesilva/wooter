<?php

namespace Wooter\Commands;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Repositories\FeatureRepository;
use Wooter\Wooter\Repositories\SportRepository;

class ReadFeaturesCommand extends Command implements SelfHandling
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
     * @param FeatureRepository $featureRepository
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function handle(FeatureRepository $featureRepository)
    {
        return $featureRepository->getAll();
    }
}
