<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cache role dan permission sebelum menjalankan seeder
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // --- DAFTAR SEMUA PERMISSION ---
        // Format: verb-noun (kata kerja-kata benda)
        $permissions = [
            // Dashboard
            'view-admin-dashboard',
            'view-manager-dashboard',
            'view-staff-dashboard',

            // Produk
            'view-products',
            'view-product-details',
            'create-products',
            'edit-products',
            'delete-products',
            'import-products',
            'export-products',

            // Kategori
            'view-categories',
            'create-categories',
            'edit-categories',
            'delete-categories',

            // Supplier
            'view-suppliers',
            'create-suppliers',
            'edit-suppliers',
            'delete-suppliers',

            // Stok
            'view-stock-history',
            'record-stock-in',
            'record-stock-out',
            'confirm-stock-in',
            'confirm-stock-out',
            'perform-stock-opname',
            'manage-minimum-stock',

            // Pengguna (User Management)
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',

            // Laporan
            'lihat-laporan-stok',
            'lihat-laporan-transaksi',
            'lihat-laporan-aktivitas',

            // Pengaturan
            'manage-app-settings',
        ];

        // Buat permission jika belum ada
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // --- BUAT ROLE DAN BERIKAN PERMISSION ---

        // 1. Role Admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        // Admin mendapatkan semua permission
        $adminRole->givePermissionTo(Permission::all());

        // 2. Role Manajer Gudang
        $managerRole = Role::firstOrCreate(['name' => 'manajer_gudang']);
        $managerRole->givePermissionTo([
            'view-manager-dashboard',
            'view-products',
            'view-product-details',
            'view-categories',
            'view-suppliers',
            'view-stock-history',
            'record-stock-in',
            'record-stock-out',
            'perform-stock-opname',
            'lihat-laporan-stok',
            'lihat-laporan-transaksi',
        ]);

        // 3. Role Staff Gudang
        $staffRole = Role::firstOrCreate(['name' => 'staff_gudang']);
        $staffRole->givePermissionTo([
            'view-staff-dashboard',
            'view-products',
            'view-product-details',
            'view-stock-history',        // ✅ TAMBAHKAN INI
            'confirm-stock-in',
            'confirm-stock-out',
            'lihat-laporan-stok',        // ✅ TAMBAHKAN INI
        ]);

        $this->command->info('✅ Role dan Permission berhasil diperbarui!');
    }
}