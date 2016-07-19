<?php

namespace Wooter\Http\Requests\Team;

use Wooter\Http\Requests\Request;

class CreateDivisionRequest extends Request
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
            'league_id' => 'required|exists:league_organizations,id',
            'name' => 'required'
        ];
    }
}
