<?php

namespace Database\Seeders;

use App\Models\Buildings;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BuildingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buildings = [
            'MSB',
            'STMB',
            'CENTRAL BUILDING',
            'Oval Building',
            'SBS',
            'Main Auditorium'
        ];

        foreach ($buildings as $building) {
            Buildings::create(['building_name' => $building]);
        }
    }
}
