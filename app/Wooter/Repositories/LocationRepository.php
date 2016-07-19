<?php

namespace Wooter\Wooter\Repositories;

use DB;
use Wooter\Location;

class LocationRepository
{

    public function create(Location $location)
    {
        return $location->push();
    }

    public function update(Location $location)
    {
        return $location->push();
    }

    public function getById($locationId) {
        return Location::whereId($locationId)->with('city', 'country')->first();
    }
}
