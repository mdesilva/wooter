<?php

namespace Wooter\Http\Requests\Wooter\Court;

use Wooter\Http\Requests\Request;

class CreateCourtManualOffRequest extends Request
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
            //
        ];
    }
}

