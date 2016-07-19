<?php

namespace Wooter\Http\Requests\Like;

use Wooter\Http\Requests\Request;

class LikeRequest extends Request
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
            'like' => 'required|boolean',
            'liked_item_type' => 'required',
        ];
    }
}