<?php

namespace App\Http\Middleware;

use Closure;

class Doktor
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
        if(!isset($user->role) or $user->role != 2){
            return redirect('/login');
        }
        return $next($request);
    }
}