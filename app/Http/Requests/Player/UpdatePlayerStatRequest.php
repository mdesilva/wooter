<?php

namespace Wooter\Http\Requests\Player;

use Wooter\Http\Requests\Request;

class UpdatePlayerStatRequest extends Request
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
            'stat_id' => 'required|exists:stats,id',
        ];
    }
}
