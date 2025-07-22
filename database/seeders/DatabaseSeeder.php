<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BusSeeder::class,
            RouteSeeder::class,
            ScheduleSeeder::class,
            AdminSeeder::class,
        ]);

        // Create test users
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
        ]);

        \App\Models\Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}
