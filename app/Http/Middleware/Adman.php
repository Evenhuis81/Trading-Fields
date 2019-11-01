<?php

namespace App\Http\Middleware;

use Closure;

class Adman
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
        if (auth()->user() == null || !auth()->user()->isAdman) {
            // return abort(403, 'Registered_Guest');
            return abort(403);
        }
        return $next($request);
    }
}
