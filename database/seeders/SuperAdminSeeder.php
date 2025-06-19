<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah user superadmin sudah ada
        if (! User::where('email', 'superadmin@example.com')->exists()) {
            User::create([
                'name'     => 'Super Admin',
                'email'    => 'superadmin@example.com',
                'password' => Hash::make('password'), // Ganti password jika perlu
                'role'     => 'superadmin',           // Pastikan kolom `role` tersedia di tabel `users`
            ]);

            $this->command->info('✅ Superadmin berhasil dibuat.');
        } else {
            $this->command->info('⚠️ Superadmin sudah ada, tidak dibuat ulang.');
        }
    }
}
