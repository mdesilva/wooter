<?php

namespace Wooter\Wooter\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see Wooter\Wooter\Auth\VerifyUser\VerifyUserBroker
 */
class UserToken extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'user_token';
    }
}
