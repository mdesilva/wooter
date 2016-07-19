<?php

namespace Wooter\Http\Middleware;

use Closure;
use Crypt;

class MediaCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $data = $request->all();

        if ($data['t'] != csrf_token()) {
            return abort(404);
        }

        return $next($request);
    }
}
