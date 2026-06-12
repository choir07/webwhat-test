<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SetupRoles extends Command
{
    protected $signature = 'setup:roles';
    protected $description = 'Create roles and permissions and assign to admin user';

    public function handle()
    {
        $this->info('Setting up roles and permissions...');

        // Create permissions
        $permissions = [
            "view users", "create users", "edit users", "delete users",
            "view roles", "create roles", "edit roles", "delete roles",
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(["name" => $perm, "guard_name" => "web"]);
            $this->line("  Created permission: $perm");
        }

        // Create roles
        $adminRole = Role::firstOrCreate(["name" => "admin", "guard_name" => "web"]);
        $editorRole = Role::firstOrCreate(["name" => "editor", "guard_name" => "web"]);
        $viewerRole = Role::firstOrCreate(["name" => "viewer", "guard_name" => "web"]);

        $this->info("Roles created: admin, editor, viewer");

        // Assign all permissions to admin
        $adminRole->syncPermissions(Permission::all());
        $this->info("Admin role has all permissions");

        // Assign admin role to user ID 1
        $user = User::find(1);
        if ($user) {
            $user->assignRole("admin");
            $this->info("Admin role assigned to user: {$user->name}");
        } else {
            $this->error("User with ID 1 not found!");
        }

        $this->newLine();
        $this->info("Setup complete!");
    }
}