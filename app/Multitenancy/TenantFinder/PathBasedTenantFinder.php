<?php
namespace App\MultiTenancy\TenantFinder;

use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\TenantFinder\TenantFinder;

class PathBasedTenantFinder extends TenantFinder
{
    public function findForRequest(Request $request): ?Tenant
    {
        // Skip tenant resolution untuk superadmin routes
        if (str_starts_with($request->path(), 'api/superadmin')) {
            return null;
        }

                                      // Contoh: ambil slug dari path pertama
        $slug = $request->segment(1); // /{slug}/endpoint

        return Tenant::where('slug', $slug)->first();
    }
}
