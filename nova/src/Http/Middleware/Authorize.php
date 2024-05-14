<?php

namespace Laravel\Nova\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Nova;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        if (!Nova::check($request)) {
            abort(403);
        }

        if (Auth::user()->hasRole('vendor')){
            return redirect(url('/login'));
        }
        return $next($request);
    }
}
