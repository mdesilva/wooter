<?php

namespace Wooter\Wooter\Repositories;

use Illuminate\Support\Facades\DB;
use Wooter\SeasonStructure;

class SeasonStructureRepository
{

    public function create(SeasonStructure $seasonStructure)
    {
        return $seasonStructure->save();
    }

    public function update(SeasonStructure $seasonStructure)
    {
        return $seasonStructure->save();
    }

    public function getById($seasonStructureId) {
        return SeasonStructure::whereId($seasonStructureId)->first();
    }

    public function search($params) {
        $query = DB::table('countrys');

        if (isset($params['name']) && $params['name'] !== '') {
            $query->whereRaw('lower(season_structures.name) LIKE lower(?)', ['%'.$params['name'].'%']);
        }

        return $query->get();

    }

    public function getAll()
    {
        return SeasonStructure::all();
    }
}
