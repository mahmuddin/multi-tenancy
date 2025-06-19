<?php
namespace App\Multitenancy;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Spatie\Multitenancy\TenantFinder\TenantFinder;

class PathTenantFinder extends TenantFinder
{
    public function findForRequest(Request $request): ?Tenant
    {
        $segments = $request->segments();
        $slug     = $segments[0] ?? null;

        if (! $slug) {
            return null;
        }

        return Tenant::where('slug', $slug)->first();
    }
}
