<?php

namespace Wooter\Wooter\Contracts\Auth;

use Wooter\Wooter\Contracts\Auth\CanVerifyUser as CanVerifyUserContract;

interface TokenRepositoryContract
{
    /**
     * Create a new token.
     *
     * @param  CanVerifyUserContract  $user
     * @return string
     */
    public function create(CanVerifyUserContract $user);

    /**
     * Determine if a token record exists and is valid.
     *
     * @param  CanVerifyUserContract  $user
     * @param  string  $token
     * @return bool
     */
    public function exists(CanVerifyUserContract $user, $token);

    /**
     * Delete a token record.
     *
     * @param  string  $token
     * @return void
     */
    public function delete($token);

    /**
     * Delete expired tokens.
     *
     * @return void
     */
    public function deleteExpired();
}
