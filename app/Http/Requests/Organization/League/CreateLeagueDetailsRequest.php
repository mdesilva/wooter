<?php

namespace Wooter\Http\Requests\Organization\League;

use Wooter\Http\Requests\Request;

class CreateLeagueDetailsRequest extends Request
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
            'description' => 'required',
            'number_of_teams' => 'required|integer',
            'players_per_team' => 'required|integer',
            'games_per_team' => 'required|integer',
            'max_players' => 'integer',
            'game_duration' => 'required|integer',
            'time_period' => 'integer',
        ];
    }
}
