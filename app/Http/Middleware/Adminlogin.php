<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Adminlogin
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
        if (empty(Session::has('AdminSession'))) {
            return redirect('/admin_login');
        }
        return $next($request);
    }
}
