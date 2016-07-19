<?php

namespace Wooter\Http\Requests\Organization\League;

use Wooter\Http\Requests\Request;

class CreateLeagueSeasonRequest extends Request
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
            'name' => 'required',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date',
            'registration_opens_at' => 'required|date',
            'registration_closes_at' => 'required|date',
            'max_teams' => 'integer',
            'min_teams' => 'integer',
            'max_free_agents' => 'integer',
            'min_free_agents' => 'integer',
        ];
    }
}
