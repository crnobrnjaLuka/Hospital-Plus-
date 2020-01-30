<?php

namespace App\Http\Middleware;

use Closure;

class Dokt_osob
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
        $user=$request->user();
        if(isset($user->role))
        {
            if($user->role==1) return $next($request);
            if($user->role==2) return $next($request);
        }
            return redirect('/login');
    }
}
