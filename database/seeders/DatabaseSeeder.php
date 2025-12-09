<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\MinistrySeeder;
use Database\Seeders\RoleSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MinistrySeeder::class,
            RoleSeeder::class,
        ]);
    }
}
