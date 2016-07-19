<?php

namespace Wooter\Http\Requests\Player;

use Wooter\Http\Requests\Request;

class UpdatePlayerInfoRequest extends Request
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
            'email' => 'required|email|max:255',
            'first_name' => 'required|max:150',
            'last_name' => 'required|max:150',
            'birthday' => 'date',
            'phone' => 'required',
            'position' => '',
            'school' => '',
            'city' => '',
            'state' => '',
            'gender' => 'in:male,female,other',
        ];
    }
}
