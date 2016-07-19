<?php

namespace Wooter\Wooter\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see Wooter\Wooter\Auth\VerifyUser\VerifyUserBroker
 */
class VerifyUser extends Facade
{
    /**
     * Constant representing a successfully sent reminder.
     *
     * @var string
     */
    const VERIFY_USER_LINK_SENT = 'auth.verify_user.sent';

    /**
     * Constant representing a successfully verified user.
     *
     * @var string
     */
    const USER_VERIFIED = 'auth.verify_user.verified';

    /**
     * Constant representing the user not found response.
     *
     * @var string
     */
    const INVALID_USER = 'auth.verify_user.user';

    /**
     * Constant representing an invalid token.
     *
     * @var string
     */
    const INVALID_TOKEN = 'auth.verify_user.token';

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'auth.verify_user';
    }
}
