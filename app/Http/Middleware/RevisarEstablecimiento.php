<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

class RevisarEstablecimiento
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    //    dd('desde md');
        if(Auth()->user()->establecimiento){
            return redirect('/establecimiento/edit');
        }
        // return $next($request);
    }
}
