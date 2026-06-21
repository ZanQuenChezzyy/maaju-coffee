<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Permissions for users and all models
        $permissions = [
            'View Any User', 'View User', 'Create User', 'Update User', 'Delete User', 'Restore User', 'Force Delete User',
            'View Any Role', 'View Role', 'Create Role', 'Update Role', 'Delete Role', 'Restore Role', 'Force Delete Role',
            'View Any Permission', 'View Permission', 'Create Permission', 'Update Permission', 'Delete Permission', 'Restore Permission', 'Force Delete Permission',
            
            // Models Permissions
            'View Any Category', 'View Category', 'Create Category', 'Update Category', 'Delete Category',
            'View Any Menu', 'View Menu', 'Create Menu', 'Update Menu', 'Delete Menu',
            'View Any Table', 'View Table', 'Create Table', 'Update Table', 'Delete Table',
            'View Any Order', 'View Order', 'Create Order', 'Update Order', 'Delete Order',
            'View Any Transaction', 'View Transaction', 'Create Transaction', 'Update Transaction', 'Delete Transaction',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $roles = [
            'Administrator' => $permissions, // Administrator gets all permissions
            'Owner' => array_filter($permissions, function($perm) {
                // Owner can view everything, maybe update some, but generally view all
                return str_starts_with($perm, 'View');
            }),
            'Kasir' => [
                'View Any Category', 'View Category',
                'View Any Menu', 'View Menu',
                'View Any Table', 'View Table',
                'View Any Order', 'View Order', 'Create Order', 'Update Order',
                'View Any Transaction', 'View Transaction', 'Create Transaction',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions(array_values($rolePermissions));
        }

        // Create users and assign roles
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@starter.com',
                'password' => Hash::make('12345678'),
                'role' => 'Administrator',
            ],
            [
                'name' => 'Owner',
                'email' => 'owner@starter.com',
                'password' => Hash::make('12345678'),
                'role' => 'Owner',
            ],
            [
                'name' => 'Kasir',
                'email' => 'kasir@starter.com',
                'password' => Hash::make('12345678'),
                'role' => 'Kasir',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                ]
            );

            $user->assignRole($userData['role']);
        }

        $this->command->info('Roles, Permissions, dan Users Telah berhasil dibuat!');
    }
}

