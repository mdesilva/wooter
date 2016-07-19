<?php

namespace Wooter\Http\Requests\Player;

use Wooter\Http\Requests\Request;
use Wooter\Role;

class CreatePlayerRequest extends Request
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
            'email' => 'required|unique:users|email|max:255',
            'first_name' => 'required|max:150',
            'last_name' => 'required|max:150',
            'birthday' => 'required|date',
            'phone' => 'required',
            'picture' => '',
            'gender' => 'in:male,female,other',
            'league_id' => 'exists:league_organizations,id',
            'team_id' => 'exists:teams,id',
        ];
    }
}
