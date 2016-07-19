<?php

namespace Wooter\Wooter\Repositories\Team;

use DB;
use Auth;
use Wooter\Division;

class DivisionRepository
{

    public function create(Division $division)
    {
        return $division->push();
    }

    public function update(Division $division)
    {
        return $division->push();
    }

    public function getById($divisionId) {
        return Division::whereId($divisionId)->first();
    }

}
