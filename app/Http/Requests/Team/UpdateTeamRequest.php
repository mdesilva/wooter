<?php

namespace Wooter\Http\Requests\Team;

use Wooter\Http\Requests\Request;

class UpdateTeamRequest extends Request
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
            'sport_id' => 'exists:sports,id',
            'captain_id' => 'exists:users,id',
            'cover_photo' => '',
            'logo' => '',
            'description' => '',
        ];
    }
}
