<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\STOB50;

class STOB50Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        STOB50::create([
            'title' => 'IS30',
        ]);
        STOB50::create([
            'title' => 'IS27',
        ]);
        STOB50::create([
            'title' => 'IS24',
        ]);
        STOB50::create([
            'title' => 'IS21',
        ]);
        STOB50::create([
            'title' => 'AO21',
        ]);
        STOB50::create([
            'title' => 'R15',
        ]);
        STOB50::create([
            'title' => 'CLK15',
        ]);
        STOB50::create([
            'title' => 'SPO27',
        ]);
        STOB50::create([
            'title' => 'IS18',
        ]);
        STOB50::create([
            'title' => 'Band 3',
        ]);
        STOB50::create([
            'title' => 'Band 4',
        ]);
        
    }
}
