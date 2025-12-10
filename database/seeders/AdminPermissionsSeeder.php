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
            'ViewAny:Application',
            'View:Application',
            'Create:Application',
            'Edit:Application',
            'Delete:Application',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'sanctum',
        ]);

        $adminRole->syncPermissions($permissions);
    }
}
