<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- Buat atau Update User Admin ---
        // Menggunakan updateOrCreate untuk mencegah error jika dijalankan berkali-kali
        $admin = User::updateOrCreate(
            ['email' => 'admin@stockify.com'], // Kunci pencarian
            [
                'name' => 'Admin Stockify',
                'password' => Hash::make('admin123')
            ]
        );
        // Pastikan nama role 'admin' sama persis dengan di RolePermissionSeeder
        $admin->assignRole('admin');

        // --- Buat atau Update User Manajer Gudang ---
        $manager = User::updateOrCreate(
            ['email' => 'manager@stockify.com'],
            [
                'name' => 'Manajer Gudang',
                'password' => Hash::make('manager123')
            ]
        );
        // ✅ PERBAIKAN: Nama role diubah menjadi 'manajer_gudang' (gunakan underscore)
        // Ini untuk konsistensi dan menghindari masalah dengan middleware.
        $manager->assignRole('manajer_gudang');

        // --- Buat atau Update User Staff Gudang ---
        $staff = User::updateOrCreate(
            ['email' => 'staff@stockify.com'],
            [
                'name' => 'Staff Gudang',
                'password' => Hash::make('staff123')
            ]
        );
        // ✅ PERBAIKAN: Nama role diubah menjadi 'staff_gudang' agar lebih spesifik
        $staff->assignRole('staff_gudang');

        // --- Tambahkan Feedback ke Console ---
        // Ini akan membantu Anda mengetahui akun apa saja yang telah dibuat.
        $this->command->info('✅ User berhasil dibuat dan role telah ditetapkan!');
        $this->command->info('   - Email: admin@stockify.com      | Role: admin');
        $this->command->info('   - Email: manager@stockify.com   | Role: manajer_gudang');
        $this->command->info('   - Email: staff@stockify.com     | Role: staff_gudang');
        $this->command->warn('   Password default untuk semua akun adalah: (sesuai username)123');
        $this->command->warn('   ⚠️  UBAH PASSWORD DEFAULT ini di lingkungan produksi!');
    }
}