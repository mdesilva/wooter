<?php

namespace Wooter\Wooter\Repositories;

use Illuminate\Support\Facades\DB;
use Wooter\Country;

class CountryRepository
{

    public function create(Country $country)
    {
        return $country->save();
    }

    public function update(Country $country)
    {
        return $country->save();
    }

    public function getById($countryId) {
        return Country::whereId($countryId)->first();
    }

    public function search($params) {
        $query = DB::table('countries');

        if (isset($params['name']) && $params['name'] !== '') {
            $query->whereRaw('lower(countries.name) LIKE lower(?)', ['%'.$params['name'].'%']);
        }

        return $query->get();

    }

    public function getAll()
    {
        return Country::all();
    }
}
