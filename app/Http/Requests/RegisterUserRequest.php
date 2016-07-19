<?php

namespace Wooter\Http\Requests;

use Wooter\Role;

class RegisterUserRequest extends Request
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
            'preselected_role' => 'required|in:' . Role::PLAYER . ',' . Role::ORGANIZATION,
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'first_name' => 'required|max:150',
            'last_name' => 'required|max:150',
            'phone' => 'required|unique:users',
        ];
    }
}
