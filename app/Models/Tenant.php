<?php
namespace App\Models;

use Spatie\Multitenancy\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    // Gunakan koneksi landlord karena tenants disimpan di DB pusat
    protected $connection = 'landlord';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'database',
        'email',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function getDatabaseName(): string
    {
        return $this->database;
    }

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }
    public function makeCurrent(): static
    {
        // Jalankan task custom
        app(\App\Multitenancy\Tasks\SwitchTenantDatabaseTask\TenantDatabaseManager::class)
            ->makeCurrent($this);

        // Jalankan bawaan Spatie
        return parent::makeCurrent();
    }
}
