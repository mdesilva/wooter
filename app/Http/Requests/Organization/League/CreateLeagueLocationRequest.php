<?php

namespace Wooter\Http\Requests\Organization\League;

use Wooter\Http\Requests\Request;

class CreateLeagueLocationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'league_id' => 'required|exists:league_organizations,id',
            'name' => 'required',
            'street' => 'required',
            'flat' => '',
            'zip' => 'required',
            'country_id' => 'required|exists:countries,id',
            'state' => '',
            'longitude' => '',
            'latitude' => '',
            'full_address' => '',
            'city_id' => 'required|exists:cities,id',
        ];
    }
}
