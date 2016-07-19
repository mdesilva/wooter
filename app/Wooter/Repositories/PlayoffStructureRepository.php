<?php

namespace Wooter\Wooter\Repositories;

use Illuminate\Support\Facades\DB;
use Wooter\PlayoffStructure;

class PlayoffStructureRepository
{

    public function create(PlayoffStructure $playoffStructure)
    {
        return $playoffStructure->save();
    }

    public function update(PlayoffStructure $playoffStructure)
    {
        return $playoffStructure->save();
    }

    public function getById($playoffStructureId) {
        return PlayoffStructure::whereId($playoffStructureId)->first();
    }

    public function search($params) {
        $query = DB::table('playoff_structures');

        if (isset($params['name']) && $params['name'] !== '') {
            $query->whereRaw('lower(playoff_structures.name) LIKE lower(?)', ['%'.$params['name'].'%']);
        }

        return $query->get();

    }

    public function getAll()
    {
        return PlayoffStructure::all();
    }
}
