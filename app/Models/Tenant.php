<?php
namespace App\Models;

use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
use Spatie\Multitenancy\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    use UsesTenantConnection;

    public function getDatabaseName(): string
    {
        return $this->database;
    }
}
