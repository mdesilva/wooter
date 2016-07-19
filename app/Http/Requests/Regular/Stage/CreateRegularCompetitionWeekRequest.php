<?php

namespace Wooter\Http\Requests\Regular\Stage;

use Wooter\Http\Requests\Request;

class CreateRegularCompetitionWeekRequest extends Request
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
            'starts_at' => 'required|date',
            'ends_at' => 'required|date',
            'name' => 'required',
        ];
    }
}
