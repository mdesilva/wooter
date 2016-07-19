<?php

namespace Wooter\Http\Requests\Player;

use Wooter\Http\Requests\Request;

class DeletePlayerTeamRequest extends Request
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
            'competition_type' => 'required|in:Wooter\\League',
            'competition_id' => 'required|numeric'
        ];
    }
}
