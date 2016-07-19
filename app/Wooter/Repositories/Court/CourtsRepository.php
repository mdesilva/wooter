<?php

namespace Wooter\Wooter\Repositories\Court;

use DB;
use Wooter\Court;

class CourtsRepository
{

    public function create(Court $court)
    {
        return $court->save();
    }

    public function update(Mailbox $court)
    {
        return $court->save();
    }

    public function getById($court_id)
    {
        return Court::whereId($court_id)->first();
    }
    
    public function all() 
    {
        return Court::all();
    }
}

