<?php

namespace Wooter\Http\Requests;

use Wooter\Http\Requests\Request;

class ScheduleDemoRequest extends Request
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
            'email' => 'required|email|max:255|unique:users',
            'name' => 'required|max:150',
            'comments' => 'required|max:150',
            'phone' => 'required',
        ];
    }
}
