<?php

namespace Wooter\Http\Requests\Search;

use Wooter\Http\Requests\Request;

class FullSearchRequest extends Request
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
            'name' => '',
            'sport' => '',
            'min_age' => '',
            'max_age' => '',
            'longitude' => '',
            'latitude' => '',
            'distance' => '',
            'gender' => '',
        ];
    }
}
