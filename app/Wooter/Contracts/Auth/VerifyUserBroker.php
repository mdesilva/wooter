<?php

namespace Wooter\Wooter\Contracts\Auth;

use Closure;

interface VerifyUserBroker
{
    /**
     * Constant representing a successfully sent reminder.
     *
     * @var string
     */
    const VERIFY_USER_LINK_SENT = 'verify_user.sent';

    /**
     * Constant representing a successfully verified user.
     *
     * @var string
     */
    const USER_VERIFIED = 'verify_user.verified';

    /**
     * Constant representing the user not found response.
     *
     * @var string
     */
    const INVALID_USER = 'verify_user.user';

    /**
     * Constant representing an invalid token.
     *
     * @var string
     */
    const INVALID_TOKEN = 'verify_user.token';

    /**
     * Send a verify user link to a user.
     *
     * @param  array  $credentials
     * @param  \Closure|null  $callback
     * @return string
     */
    public function sendVerifyUserLink(array $credentials, Closure $callback = null);

    /**
     * Verify the user for the given token.
     *
     * @param $token
     * @param  \Closure $callback
     * @return mixed
     */
    public function verify($token, Closure $callback);

}
