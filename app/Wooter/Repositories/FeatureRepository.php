<?php

namespace Wooter\Wooter\Repositories;

use Illuminate\Support\Facades\DB;
use Wooter\Feature;

class FeatureRepository
{

    public function create(Feature $feature)
    {
        return $feature->save();
    }

    public function update(Feature $feature)
    {
        return $feature->save();
    }

    public function getById($featureId) {
        return Feature::whereId($featureId)->first();
    }

    public function search($params) {
        $query = DB::table('features');

        if (isset($params['name']) && $params['name'] !== '') {
            $query->whereRaw('lower(features.name) LIKE lower(?)', ['%'.$params['name'].'%']);
        }

        return $query->get();

    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return Feature::all();
    }
}
