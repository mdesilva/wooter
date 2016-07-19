<?php

namespace Wooter\Wooter\Repositories;

use Illuminate\Support\Facades\DB;
use Wooter\GameStructure;

class GameStructureRepository
{

    public function create(GameStructure $gameStructure)
    {
        return $gameStructure->save();
    }

    public function update(GameStructure $gameStructure)
    {
        return $gameStructure->save();
    }

    public function getById($gameStructureId) {
        return GameStructure::whereId($gameStructureId)->first();
    }

    public function search($params) {
        $query = DB::table('game_structures');

        if (isset($params['name']) && $params['name'] !== '') {
            $query->whereRaw('lower(game_structures.name) LIKE lower(?)', ['%'.$params['name'].'%']);
        }

        return $query->get();

    }

    public function getAll()
    {
        return GameStructure::all();
    }
}
