<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        //Ensure guard_name 'web' exists
        $guardName = 'web';

        // Create or find the admin role
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => $guardName,
        ]);

        // List of required base permissions
        $basePermissions = [
            'manage-users',
            'create-user',
            'read-user',
            'update-user',
            'delete-user',
            'manage-permissions',
            'create-permission',
            'read-permission',
            'update-permission',
            'delete-permission',
            'manage-roles',
            'create-role',
            'read-role',
            'update-role',
            'delete-role',
        ];

        // Create or find permissions and assign to the admin role
        foreach ($basePermissions as $permissionName) {
            $permission = Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => $guardName,
            ]);

            $adminRole->givePermissionTo($permission);
        }

        // Create an admin user (if one does not exist)
        $adminUser = User::firstOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'name' => 'admin',
            'password' => Hash::make('admin'),
            'email_verified_at' => now(), // Verified email
        ]);

        // Assigning the admin role to a user
        $adminUser->assignRole($adminRole);


        // Log if needed
        $this->command->info('✅ Admin user created with role and direct permission:');
        $this->command->info('Email: admin@admin.com');
        $this->command->info('Password: admin');
        $this->command->info('Role: admin');
        $this->command->info('Email verified: yes');
    }
}
