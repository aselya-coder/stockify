<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        DB::transaction(function () {
            // Define permissions
            $permissions = [
                // dashboard
                'dashboard.view',
                // category
                'category.view', 'category.create', 'category.update', 'category.delete',
                // supplier
                'supplier.view', 'supplier.create', 'supplier.update', 'supplier.delete',
                // product
                'product.view', 'product.create', 'product.update', 'product.delete',
                // stock
                'stock.view', 'stock.in', 'stock.out',
                // user management (admin only)
                'user.manage',
            ];

            foreach ($permissions as $perm) {
                Permission::firstOrCreate(['name' => $perm]);
            }

            // Create roles
            $admin   = Role::firstOrCreate(['name' => 'admin']);
            $manager = Role::firstOrCreate(['name' => 'manager']);
            $staff   = Role::firstOrCreate(['name' => 'staff']);

            // Assign permissions to roles
            $admin->syncPermissions(Permission::all());

            $manager->syncPermissions([
                'dashboard.view',
                'category.view', 'category.create', 'category.update', 'category.delete',
                'supplier.view', 'supplier.create', 'supplier.update', 'supplier.delete',
                'product.view', 'product.create', 'product.update', 'product.delete',
                'stock.view', 'stock.in', 'stock.out',
            ]);

            $staff->syncPermissions([
                'dashboard.view',
                'product.view',
                'stock.view', 'stock.in', 'stock.out',
            ]);

            // Attach roles to existing seeded users if present
            $adminUser = User::where('email', 'admin@stockify.com')->first();
            if ($adminUser) { $adminUser->assignRole('admin'); }

            $managerUser = User::where('email', 'manager@stockify.com')->first();
            if ($managerUser) { $managerUser->assignRole('manager'); }

            $staffUser = User::where('email', 'staff@stockify.com')->first();
            if ($staffUser) { $staffUser->assignRole('staff'); }
        });

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
