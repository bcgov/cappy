<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BusinessArea;

class BusinessAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BusinessArea::create([
            'name' => 'Social Sector',
        ]);
        
        BusinessArea::create([
            'name' => 'Social Development & Poverty Reduction',
        ]);

        BusinessArea::create([
            'name' => 'Child & Family Development',
        ]);

        BusinessArea::create([
            'name' => 'Education & Child Care',
        ]);

        //SDPR
        BusinessArea::create([
            'name' => 'Accessibility Directorate',
        ]);

        BusinessArea::create([
            'name' => 'Corporate Services',
        ]);

        BusinessArea::create([
            'name' => 'Employment and Labour Market',
        ]);

        BusinessArea::create([
            'name' => 'Research, Innovation & Policy',
        ]);

        BusinessArea::create([
            'name' => 'Service Delivery',
        ]);

        //CFD
        BusinessArea::create([
            'name' => 'Service Delivery',
        ]);

        BusinessArea::create([
            'name' => 'Policy, Legislation, and Litigation',
        ]);

        BusinessArea::create([
            'name' => 'Partnership & Indigenous Engagement',
        ]);

        BusinessArea::create([
            'name' => 'Indigenous Child Welfare',
        ]);

        BusinessArea::create([
            'name' => 'Practice & Quality Assurance',
        ]);

        BusinessArea::create([
            'name' => 'Finance & Corporate Services',
        ]);

        BusinessArea::create([
            'name' => 'Youth Justice Services',
        ]);

       
    }
}
