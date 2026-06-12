<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all permissions
        $permissions = [
            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Role permissions
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            // Product permissions
            'view products',
            'create products',
            'edit products',
            'delete products',

            // Post permissions
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',

            // Category permissions
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',

            // Settings permissions
            'view settings',
            'edit settings',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $viewerRole = Role::firstOrCreate(['name' => 'viewer']);

        // Assign all permissions to admin
        $adminRole->givePermissionTo(Permission::all());

        // Assign editor permissions
        $editorRole->givePermissionTo([
            'view products', 'create products', 'edit products',
            'view posts', 'create posts', 'edit posts',
            'view categories', 'create categories', 'edit categories',
        ]);

        // Assign viewer permissions (read-only)
        $viewerRole->givePermissionTo([
            'view products', 'view posts', 'view categories',
        ]);

        // Assign admin role to user ID 1 (your admin account)
        $user = \App\Models\User::find(1);
        if ($user) {
            $user->assignRole('admin');
        }
    }
}