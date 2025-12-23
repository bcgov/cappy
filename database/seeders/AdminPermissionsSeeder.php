<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'view-admin',
            'ViewAny:Application',
            'View:Application',
            'Create:Application',
            'Edit:Application',
            'Delete:Application',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $adminRole->syncPermissions($permissions);
    }
}
