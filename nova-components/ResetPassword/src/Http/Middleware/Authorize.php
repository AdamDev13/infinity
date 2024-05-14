<?php
namespace Ugduck\ResetPassword\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Ugduck\ResetPassword\ResetPassword;

class Authorize
{
    public function handle(Request $request, Closure $next): Response
    {
        return app(ResetPassword::class)->authorize($request)
            ? $next($request)
            : abort(403);
    }
}
