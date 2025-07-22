<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $schedules = [];

        // Generate schedules for next 7 days
        for ($day = 0; $day < 7; $day++) {
            $date = Carbon::now()->addDays($day);

            // Multiple schedules per day for different routes and buses
            $times = [
                ['06:00', '09:30'],
                ['08:00', '11:30'],
                ['10:00', '13:30'],
                ['14:00', '17:30'],
                ['16:00', '19:30'],
                ['20:00', '23:30'],
            ];

            foreach ($times as $time) {
                for ($busId = 1; $busId <= 5; $busId++) {
                    for ($routeId = 1; $routeId <= 8; $routeId++) {
                        $departureTime = $date->copy()->setTimeFromTimeString($time[0]);
                        $arrivalTime = $date->copy()->setTimeFromTimeString($time[1]);

                        // Skip if departure time is in the past
                        if ($departureTime->isPast()) {
                            continue;
                        }

                        $schedules[] = [
                            'bus_id' => $busId,
                            'route_id' => $routeId,
                            'departure_time' => $departureTime,
                            'arrival_time' => $arrivalTime,
                            'price' => rand(50000, 300000),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }
        }

        // Insert in chunks to avoid memory issues
        foreach (array_chunk($schedules, 100) as $chunk) {
            Schedule::insert($chunk);
        }
    }
}
