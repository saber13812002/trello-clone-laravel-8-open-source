<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

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
            return redirect('/dashboard');
        }

        // if (!$this->app->environment('local')) {
        //     URL::forceSchema('https');
        // }

        // if (Auth::guard($guard)->check()) {
        //     // the following 3 lines
        //     if (Auth::user()->is_admin) {
        //         return redirect('/admin');
        //     }
        //     return redirect('/home');
        // }

        return $next($request);
    }
}
