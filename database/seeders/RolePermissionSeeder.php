<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'dashboard_access',
            'user_management_access',
            'role_management_access',
            'permission_management_access',
            'ticket_management_access',
            'view_visits',
            'view_add_user',
            'create_user',
            'create_admin',
            'create_supervisor',
            'create_representative',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superadmin = Role::firstOrCreate(['name' => 'superadmin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'supervisor']);
        Role::firstOrCreate(['name' => 'representative']);

        $superadmin->syncPermissions(Permission::all());

        $admin->syncPermissions(['view_add_user', 'create_user', 'create_supervisor','create_representative']);


    }
}
