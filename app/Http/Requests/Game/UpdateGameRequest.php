<?php

namespace Wooter\Http\Requests\Game;

use Wooter\Http\Requests\Request;

class UpdateGameRequest extends Request
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
            'home_team_id' => 'required|exists:teams,id',
            'visiting_team_id' => 'required|exists:teams,id',
            'sport_id' => 'required|exists:sports,id',
            'stage_id' => 'required|exists:regular_stages,id',
            'game_venue_id' => 'required|exists:game_venues,id',
            'stage_type' => 'required',
            'time' => 'required',
        ];
    }
}

