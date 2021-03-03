<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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
        if (Auth::user()->user_level == 1) {
            return redirect(route('users.home'));
        }else{
            if (Auth::user()->user_level >= 8) {
                return $next($request);
            }else{
                return redirect('home');
            }
            
        }
        
    }
}
