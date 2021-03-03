<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsVerified
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
        if(!Auth::guard('resident')->check()){
            $isVerified = Auth::user()->isVerified;
            if($isVerified != 1){
                return redirect(route('users.verify'));
            }
            return $next($request);
        }else{
          $verify = Auth::guard('resident')->user()->verify;
            if($verify != 1){
                return redirect(route('users.verify'));
            }
            return $next($request);

        }

    
 
    }
}
