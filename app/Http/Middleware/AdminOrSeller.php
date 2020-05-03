<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminOrSeller
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
        if(Auth::user()->IsAdmin || Auth::user()->IsSeller){
            return $next($request);
        }
        
        return redirect()->route('home')->with('error', 'Unauthorized access');
    }
}
