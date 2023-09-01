<?php

namespace Database\Seeders;

use App\Models\Faults;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FaultsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faults = [
            'Sound(Amp & Speakers)',
            'Alignment & Clarity',
            'Screen',
            'Screen Controller',
            'Browser Ops/ Remote',
            'Network',
            'Internet',
            'Anti-virus',
            'PC & Projector Cabinet Security',
            'AV Guideline Sheet',
            'Clock',
            'Potrait',
            'Light',
            'Door',
        ];

        foreach ($faults as $fault) {
            Faults::create(['faults_identified' => $fault]);
        }
    }
}
