<?php
namespace App\Models;

use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase;

    protected $fillable = [
        'id',
        'data',
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'data',
        ];
    }

    // Helper method untuk validasi tenant
    public static function findBySlug($slug)
    {
        return static::where('id', $slug)->first();
    }
}
