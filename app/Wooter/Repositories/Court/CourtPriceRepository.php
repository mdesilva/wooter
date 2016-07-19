<?php

namespace Wooter\Wooter\Repositories\Court;

use DB;
use Wooter\CourtPrice;

class CourtPriceRepository
{

    public function create(CourtPrice $price)
    {
        return $price->save();
    }

    public function update(CourtPrice $price)
    {
        return $price->save();
    }

    public function getById($price_id)
    {
        return CourtPrice::whereId($price_id)->first();
    }
}

