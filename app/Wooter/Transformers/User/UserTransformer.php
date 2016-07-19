<?php

namespace Wooter\Wooter\Transformers\User;

use Carbon\Carbon;
use Wooter\User;
use Wooter\Wooter\Transformers\Transformer;

class UserTransformer extends Transformer
{
    public function transform($user)
    {
        $result = [
            'id' => $user->id,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone' => $user->phone,
            'gender' => $user->gender,
            'picture' => $user->picture,
            'active' => $user->active,
            'created_at'=>$user->created_at,
            'updated_at'=>$user->updated_at,
            'birthday' => ($user->birthday instanceof Carbon) ? $user->birthday->toDateString() : $user->birthday,
            'roles' => $user->roles ? $user->roles->toArray() : null
        ];

        return $result;
    }
}