<?php

namespace Wooter\Wooter\Auth\VerifyUser;

trait CanVerifyUser
{
    /**
     * Get the e-mail address where verify user links are sent.
     *
     * @return string
     */
    public function getEmailForVerifyUser()
    {
        return $this->email;
    }
}
