<?php

namespace Wooter\Http\Middleware\User;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class UserIsOrganizationStaff
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->user()->isOrganizationStaff()) {
            return $next($request);
        }
    }
}
