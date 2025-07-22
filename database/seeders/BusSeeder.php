<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bus;

class BusSeeder extends Seeder
{
    public function run(): void
    {
        $buses = [
            [
                'name' => 'Primajasa Executive',
                'plate_number' => 'B 1234 ABC',
                'capacity' => 40,
            ],
            [
                'name' => 'Sinar Jaya Super Executive',
                'plate_number' => 'B 5678 DEF',
                'capacity' => 35,
            ],
            [
                'name' => 'Rosalia Indah Premium',
                'plate_number' => 'B 9012 GHI',
                'capacity' => 45,
            ],
            [
                'name' => 'Haryanto Luxury',
                'plate_number' => 'B 3456 JKL',
                'capacity' => 38,
            ],
            [
                'name' => 'Pahala Kencana VIP',
                'plate_number' => 'B 7890 MNO',
                'capacity' => 42,
            ],
        ];

        foreach ($buses as $bus) {
            Bus::create($bus);
        }
    }
}
