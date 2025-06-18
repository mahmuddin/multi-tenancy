<?php
namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Tenancy;
use Symfony\Component\HttpFoundation\Response;

class InitializeTenancyByPath
{
    protected $tenancy;

    public function __construct(Tenancy $tenancy)
    {
        $this->tenancy = $tenancy;
    }

    public function handle(Request $request, Closure $next): Response
    {
        // Extract tenant slug from path
        $pathSegments = explode('/', trim($request->getPathInfo(), '/'));

        if (empty($pathSegments[0]) || $pathSegments[0] === 'api') {
            // Jika path dimulai dengan /api, ambil segment kedua
            $tenantSlug = $pathSegments[1] ?? null;
        } else {
            $tenantSlug = $pathSegments[0];
        }

        if (! $tenantSlug) {
            return response()->json([
                'error' => 'Tenant not specified in path',
            ], 400);
        }

        // Find tenant
        $tenant = Tenant::findBySlug($tenantSlug);

        if (! $tenant) {
            return response()->json([
                'error' => 'Tenant not found',
            ], 404);
        }

        // Initialize tenancy
        $this->tenancy->initialize($tenant);

        // Store tenant info in request for later use
        $request->attributes->set('tenant', $tenant);

        return $next($request);
    }
}
