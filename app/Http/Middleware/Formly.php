<?php

namespace Wooter\Http\Middleware;

use Closure;

class Formly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
       $cond = $request->cookie('formlyGenerator');
        if(!$cond || ( $cond && $cond != 'e302843af2e430354dba0afe38abae6db426337f'.csrf_token() ) ){
            return redirect('/formly-generator/login');
        }
        return $next($request);
    }
}
