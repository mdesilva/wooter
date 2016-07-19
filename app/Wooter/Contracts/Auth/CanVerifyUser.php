<?php

namespace Wooter\Wooter\Contracts\Auth;

interface CanVerifyUser
{
    /**
     * Get the e-mail address where verify user links are sent.
     *
     * @return string
     */
    public function getEmailForVerifyUser();
}
