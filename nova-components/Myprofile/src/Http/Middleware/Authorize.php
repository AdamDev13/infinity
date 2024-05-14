<?php
namespace Ugduck\Myprofile\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Ugduck\Myprofile\Myprofile;

class Authorize
{
    public function handle(Request $request, Closure $next): Response
    {
        return app(Myprofile::class)->authorize($request)
            ? $next($request)
            : abort(403);
    }
}
