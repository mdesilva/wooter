<?php

namespace Wooter\Wooter\Repositories;

use Illuminate\Support\Facades\DB;
use Wooter\Sport;

class SportRepository
{

    public function create(Sport $sport)
    {
        return $sport->save();
    }

    public function update(Sport $sport)
    {
        return $sport->save();
    }

    public function getById($sportId) {
        return Sport::whereId($sportId)->first();
    }

    public function search($params) {
        $query = DB::table('sports');

        if (isset($params['name']) && $params['name'] !== '') {
            $query->whereRaw('lower(sports.name) LIKE lower(?)', ['%'.$params['name'].'%']);
        }

        return $query->get();

    }

    public function getAll()
    {
        return Sport::all();
    }
}
