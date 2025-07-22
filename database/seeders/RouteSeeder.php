<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Route;

class RouteSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            [
                'origin' => 'Jakarta',
                'destination' => 'Bandung',
                'distance' => 150,
            ],
            [
                'origin' => 'Jakarta',
                'destination' => 'Yogyakarta',
                'distance' => 560,
            ],
            [
                'origin' => 'Jakarta',
                'destination' => 'Surabaya',
                'distance' => 800,
            ],
            [
                'origin' => 'Bandung',
                'destination' => 'Yogyakarta',
                'distance' => 410,
            ],
            [
                'origin' => 'Bandung',
                'destination' => 'Surabaya',
                'distance' => 650,
            ],
            [
                'origin' => 'Yogyakarta',
                'destination' => 'Surabaya',
                'distance' => 320,
            ],
            [
                'origin' => 'Jakarta',
                'destination' => 'Semarang',
                'distance' => 450,
            ],
            [
                'origin' => 'Bandung',
                'destination' => 'Solo',
                'distance' => 380,
            ],
        ];

        foreach ($routes as $route) {
            Route::create($route);
        }
    }
}
