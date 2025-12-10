<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class AdminPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'view-any Application',
            'view Application',
            'create Application',
            'edit Application',
            'delete Application',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $adminRole->syncPermissions($permissions);
    }
}
