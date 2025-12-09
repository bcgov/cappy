<?php

namespace Database\Seeders;

use App\Models\Ministry;
use Illuminate\Database\Seeder;

class MinistrySeeder extends Seeder
{
    public function run(): void
    {
        $ministries = [
            ['name' => 'Agriculture and Food', 'short_name' => 'AF'],
            ['name' => 'Attorney General', 'short_name' => 'AG'],
            ['name' => 'Children and Family Development', 'short_name' => 'MCFD'],
            ['name' => "Citizens' Services", 'short_name' => 'CITZ'],
            ['name' => 'Education and Child Care', 'short_name' => 'ECC'],
            ['name' => 'Emergency Management and Climate Readiness', 'short_name' => 'EMCR'],
            ['name' => 'Energy and Climate Solutions', 'short_name' => 'ECS'],
            ['name' => 'Environment and Parks', 'short_name' => 'ENV'],
            ['name' => 'Finance', 'short_name' => 'FIN'],
            ['name' => 'Forests', 'short_name' => 'FOR'],
            ['name' => 'Health', 'short_name' => 'HLTH'],
            ['name' => 'Housing and Municipal Affairs', 'short_name' => 'HOUS'],
            ['name' => 'Indigenous Relations and Reconciliation', 'short_name' => 'IRR'],
            ['name' => 'Infrastructure', 'short_name' => 'INFR'],
            ['name' => 'Jobs and Economic Growth', 'short_name' => 'JEDI'],
            ['name' => 'Labour', 'short_name' => 'LBR'],
            ['name' => 'Mining and Critical Minerals', 'short_name' => 'MCM'],
            ['name' => 'Post-Secondary Education and Future Skills', 'short_name' => 'PSFS'],
            ['name' => 'Public Safety and Solicitor General', 'short_name' => 'PSSG'],
            ['name' => 'Social Development and Poverty Reduction', 'short_name' => 'SDPR'],
            ['name' => 'Tourism, Arts, Culture and Sport', 'short_name' => 'TACS'],
            ['name' => 'Transportation and Transit', 'short_name' => 'MOTI'],
            ['name' => 'Water, Land and Resource Stewardship', 'short_name' => 'WLRS'],
        ];

        foreach ($ministries as $ministry) {
            Ministry::create($ministry);
        }
    }
}
