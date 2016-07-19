<?php

namespace Wooter\Http\Requests\StaticPages;

use Wooter\Http\Requests\Request;
use Wooter\ServiceRequest;

class CreateServiceRequestRequest extends Request
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
            'email' => 'required|email',
            'name' => 'required',
            'phone' => 'required',
            'sport' => 'required',
            'type' => 'required|in:' . ServiceRequest::TYPE_VIDEO . ',' . ServiceRequest::TYPE_STATS . ',' . ServiceRequest::TYPE_REFEREE,
            'address_1' => 'required',
            'address_2' => 'required',
            'number_of_players' => 'required',
            'number_of_teams' => 'required',
            'number_of_games_per_team' => 'required',
        ];
    }
}
