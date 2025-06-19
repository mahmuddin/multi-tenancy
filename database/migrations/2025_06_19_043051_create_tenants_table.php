<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('landlord')->create('tenants', function (Blueprint $table) {
            $table->id();

            // Nama tenant
            $table->string('name');

            // Slug, digunakan jika Anda memakai path-based tenancy
            $table->string('slug')->unique();

            // Nama database yang akan dibuat untuk tenant
            $table->string('database')->unique();

                                                 // Tambahan metadata opsional
            $table->string('email')->nullable(); // Email kontak tenant
            $table->json('data')->nullable();    // Data tambahan fleksibel

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('landlord')->dropIfExists('tenants');
    }
};
