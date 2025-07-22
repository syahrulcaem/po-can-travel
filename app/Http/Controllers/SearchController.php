<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SearchController extends Controller
{
    public function searchSchedules(Request $request)
    {
        $request->validate([
            'origin' => 'required|string',
            'destination' => 'required|string',
            'departure_date' => 'required|date|after_or_equal:today',
        ]);

        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $departureDate = Carbon::parse($request->input('departure_date'));

        $schedules = Schedule::with(['bus', 'route', 'tickets'])
            ->whereHas('route', function ($query) use ($origin, $destination) {
                $query->where('origin', 'like', "%{$origin}%")
                    ->where('destination', 'like', "%{$destination}%");
            })
            ->whereDate('departure_time', $departureDate)
            ->where('departure_time', '>', now())
            ->get()
            ->map(function ($schedule) {
                $availableSeats = $schedule->availableSeats();
                return [
                    'id' => $schedule->id,
                    'bus' => $schedule->bus,
                    'route' => $schedule->route,
                    'departure_time' => $schedule->departure_time,
                    'arrival_time' => $schedule->arrival_time,
                    'price' => $schedule->price,
                    'available_seats' => count($availableSeats),
                    'available_seat_numbers' => $availableSeats,
                ];
            });

        return response()->json([
            'data' => $schedules,
            'search_criteria' => [
                'origin' => $origin,
                'destination' => $destination,
                'departure_date' => $departureDate->format('Y-m-d'),
            ]
        ]);
    }

    public function index()
    {
        $routes = \App\Models\Route::all();
        return view('search.index', compact('routes'));
    }

    public function searchSchedulesWeb(Request $request)
    {
        $request->validate([
            'origin' => 'required|string',
            'destination' => 'required|string',
            'departure_date' => 'required|date|after_or_equal:today',
        ]);

        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $departureDate = Carbon::parse($request->input('departure_date'));

        $schedules = Schedule::with(['bus', 'route', 'tickets'])
            ->whereHas('route', function ($query) use ($origin, $destination) {
                $query->where('origin', 'like', "%{$origin}%")
                    ->where('destination', 'like', "%{$destination}%");
            })
            ->whereDate('departure_time', $departureDate)
            ->where('departure_time', '>', now())
            ->get()
            ->map(function ($schedule) {
                $availableSeats = $schedule->availableSeats();
                $schedule->available_seats_count = count($availableSeats);
                $schedule->available_seat_numbers = $availableSeats;
                return $schedule;
            });

        $searchCriteria = [
            'origin' => $origin,
            'destination' => $destination,
            'departure_date' => $departureDate->format('Y-m-d'),
        ];

        return view('search.results', compact('schedules', 'searchCriteria'));
    }
}
