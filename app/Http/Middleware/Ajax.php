<?php

namespace Wooter\Http\Middleware;

use Closure;
use Response;

class Ajax{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){

        if( ! $request->ajax()){
            return response()->json(['error' => 'The request was a valid request, but the server is refusing to respond to it'], 403);
        }

        return $next($request);
    }
}
