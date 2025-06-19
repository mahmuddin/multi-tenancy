<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StripTenantPath
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $segments = $request->segments();
        if (count($segments) > 1) {
            $path = implode('/', array_slice($segments, 1));
            $request->server->set('REQUEST_URI', '/' . $path);
        }

        return $next($request);
    }
}
