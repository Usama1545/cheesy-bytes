<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\helper;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
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

        helper::language();

        if (Auth::user() ){
            if(Auth::user()->type=="2") {
                return $next($request);
            }else{
                return redirect()->back();
            }
        }
        Auth::logout();
        return redirect('/');
    }
}
