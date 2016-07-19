<?php

namespace Wooter\Http\Middleware;

use Closure;
use Illuminate\Cookie\CookieJar as Cookie;

class LocalizationServices
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){

        // $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
        // $exp = 450000;
        // Cookie()->queue(cookie('_localization', $locale, $exp));

        return $next($request);
    }
}
