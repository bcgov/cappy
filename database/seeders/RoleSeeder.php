<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $user_role = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $editor_role = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        $admin_role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Assign admin role to first user
        $user = User::first();
        if ($user) {
            $user->assignRole($admin_role);
        }
    }
}
