<?php

namespace Wooter\Http\Requests\Player;

use Wooter\Http\Requests\Request;

class UpdatePlayerAwardRequest extends Request
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
            'player_id' => 'required|exists:users,id',
            'award_id' => 'required|exists:awards,id',
        ];
    }
}
