<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'sanctum']);
        Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'sanctum']);
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'sanctum']);
    }
}
