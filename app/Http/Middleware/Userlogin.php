<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Userlogin
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
        if (empty(Session::has('UserSession'))) {
            return redirect('/user/login-register');
        }
        return $next($request);
    }
}
