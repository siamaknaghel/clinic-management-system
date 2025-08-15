<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * List of models to create permissions for.
     */
    protected array $models = [
        'User',
        'Role',
        'Permission',
        'Patient',
        'Doctor',
        'Appointment',
        'MedicalRecord',
    ];

    /**
     * Actions for each model.
     */
    protected array $actions = ['create', 'read', 'update', 'delete', 'manage'];

    public function run(): void
    {
        // Ensure the roles and permissions are using the correct guard
        $guardName = 'web';

        // Create permissions for each model and action
        foreach ($this->models as $model) {
            foreach ($this->actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$action}-".strtolower($model),
                    'guard_name' => $guardName,
                ]);
            }
        }

        // Create or get the admin role
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => $guardName,
        ]);

        // Sync all permissions to the admin role
        $allPermissions = Permission::where('guard_name', $guardName)->get();
        $adminRole->syncPermissions($allPermissions);

        // Create or get the admin user
        $adminUser = User::firstOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'name' => 'System Admin',
            'password' => Hash::make('password123!'), // ✅ Stronger password
            'email_verified_at' => now(),
        ]);

        // Assign the admin role to the user
        $adminUser->assignRole($adminRole);

        $this->command->info('✅ Permissions, admin role, and admin user seeded successfully.');
        $this->command->info('👉 Login: admin@admin.com / password123!');
    }
}
