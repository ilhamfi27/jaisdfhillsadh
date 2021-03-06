<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $room = Auth::user()->room()->first();
            $userLevel = trim(Auth::user()->biodata()->first()->level);
            if($userLevel == 'admin'){
                return redirect('home/');
            } else if ($userLevel == 'rm'){
                if($room != NULL){
                    return redirect('room/' . $room->url);
                } else {
                    return redirect('room/create');
                }
            }
        }
        return $next($request);
    }
}
