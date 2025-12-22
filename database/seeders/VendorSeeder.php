<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vendor::create([
            'name' => 'Deloitte',
        ]);

        Vendor::create([
            'name' => 'CGI',
        ]);

        Vendor::create([
            'name' => 'Avocette',
        ]);

        Vendor::create([
            'name' => 'AOT'
        ]);

        
    }
}
