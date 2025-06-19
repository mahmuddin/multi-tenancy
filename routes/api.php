<?php

use App\Http\Controllers\SuperAdmin\AuthController;
use App\Http\Controllers\SuperAdmin\TenantController;
use App\Http\Controllers\Tenant\AuthController as TenantAuthController;
use App\Http\Controllers\Tenant\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini kamu bisa mendefinisikan semua route untuk API, baik untuk
| tenant (tenant-aware) maupun non-tenant (central).
|
*/

// Super admin login (no tenant context)
Route::prefix('superadmin')->name('api.')->group(function () {
    // ✅ Tanpa auth middleware
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/me', [AuthController::class, 'me'])->name('me');

        // Buat tenant baru
        Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
    });
});

// ✅ Middleware 'tenant' agar route berikut hanya jalan jika tenant dikenali
Route::prefix('{tenant}')->middleware('tenant')->group(function () {

    // ✅ Login Tenant
    Route::post('/login', [TenantAuthController::class, 'login'])->name('tenant.login');

    Route::middleware('auth:tenant-api')->group(function () {
        Route::post('/logout', [TenantAuthController::class, 'logout'])->name('tenant.logout');
        Route::get('/me', [TenantAuthController::class, 'me'])->name('tenant.me');
        // Contoh route tenant-aware untuk user management
        Route::get('/users', [UserController::class, 'index'])->name('tenant.users.index');
        Route::post('/users', [UserController::class, 'store'])->name('tenant.users.store');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('tenant.users.show');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('tenant.users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('tenant.users.destroy');

        // Tambahkan route lain tenant-aware di sini

    });
});
