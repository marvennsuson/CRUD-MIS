<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserLevel1
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next ,  $guard = 'resident')
    {

        if(Auth::check() && Auth::user()->user_level > "1"){
            if(Auth::user()->user_level > "1"){
                return redirect(route('home'));
            }else{
                return redirect('/');
            }
        }elseif(Auth::guard($guard)->check()){
            return $next($request);
        }
      
          
        
    }
}
