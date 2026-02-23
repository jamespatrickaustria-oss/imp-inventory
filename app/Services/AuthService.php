<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AuthService
{
    /**
     * Creation dial les Roles o l-Permissions l-asasiyin
     */
    public function setupRolesAndPermissions(): void
    {
        // 1. Creyi l-Permissions
        $permissions = [
            'manage inventory', // Admin & Manager
            'view stock',       // Admin, Manager, Sales
            'make sales',       // Admin, Sales
            'view reports'      // Admin only
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // 2. Creyi l-Roles o assigni l-permissions
        
        // Admin: 3ando kolshi
        $admin = Role::findOrCreate('admin');
        $admin->syncPermissions(Permission::all());

        // Manager: kiy-gérer stock walakin may-bi3ch
        $manager = Role::findOrCreate('manager');
        $manager->givePermissionTo(['manage inventory', 'view stock', 'view reports']);

        // Sales: kiy-bi3 o kiy-chouf stock ghir bach i-bi3
        $sales = Role::findOrCreate('sales');
        $sales->givePermissionTo(['view stock', 'make sales']);
    }

    /**
     * Assigni Role l-wahed l-User
     */
    public function assignRoleToUser(User $user, string $roleName): void
    {
        $user->assignRole($roleName);
    }
}