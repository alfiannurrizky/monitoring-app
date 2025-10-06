<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ===== Permissions =====
        $permissions = [
            'view alert',
            'delete alert',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // ===== Roles =====
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // ===== Assign Permissions to Roles =====
        $adminRole->givePermissionTo(['view alert', 'delete alert']);
        $userRole->givePermissionTo(['view alert']);

        $admin = User::where('email', 'soar@email.com')->first();
        if ($admin) {
            $admin->assignRole($adminRole);
        }

        $nonAdmin = User::where('email', 'user@email.com')->first();
        if ($nonAdmin) {
            $nonAdmin->assignRole($userRole);
        }

        $this->command->info('✅ Role, permission, dan user default berhasil dibuat!');
    }
}
