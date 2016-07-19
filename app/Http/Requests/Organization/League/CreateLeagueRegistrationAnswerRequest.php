<?php

namespace Wooter\Http\Requests\Organization\League;

use Wooter\Http\Requests\Request;

class CreateLeagueRegistrationAnswerRequest extends Request
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
            'registration_question_id' => 'required|exists:league_registration_questions,id',
            'user_id' => 'required|exists:users,id',
            'answer' => 'required',
        ];
    }
}
