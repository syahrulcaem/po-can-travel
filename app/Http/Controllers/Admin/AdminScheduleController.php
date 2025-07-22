<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Bus;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminScheduleController extends Controller
{
    /**
     * Display a listing of schedules
     */
    public function index(): View
    {
        $schedules = Schedule::with(['bus', 'route'])
            ->latest('departure_time')
            ->paginate(10);
        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new schedule
     */
    public function create(): View
    {
        $buses = Bus::all();
        $routes = Route::all();
        return view('admin.schedules.create', compact('buses', 'routes'));
    }

    /**
     * Store a newly created schedule
     */
    public function store(Request $request)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'route_id' => 'required|exists:routes,id',
            'departure_date' => 'required|date|after_or_equal:today',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i|after:departure_time',
            'price' => 'required|numeric|min:0',
        ]);

        // Combine date and time for departure_time
        $departureDateTime = $request->departure_date . ' ' . $request->departure_time;

        // Calculate arrival time (assuming same day for now)
        $arrivalDateTime = $request->departure_date . ' ' . $request->arrival_time;

        Schedule::create([
            'bus_id' => $request->bus_id,
            'route_id' => $request->route_id,
            'departure_time' => $departureDateTime,
            'arrival_time' => $arrivalDateTime,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified schedule
     */
    public function edit(Schedule $schedule): View
    {
        $buses = Bus::all();
        $routes = Route::all();
        return view('admin.schedules.edit', compact('schedule', 'buses', 'routes'));
    }

    /**
     * Update the specified schedule
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'route_id' => 'required|exists:routes,id',
            'departure_date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'required|date_format:H:i|after:departure_time',
            'price' => 'required|numeric|min:0',
        ]);

        // Combine date and time for departure_time
        $departureDateTime = $request->departure_date . ' ' . $request->departure_time;

        // Calculate arrival time (assuming same day for now)
        $arrivalDateTime = $request->departure_date . ' ' . $request->arrival_time;

        $schedule->update([
            'bus_id' => $request->bus_id,
            'route_id' => $request->route_id,
            'departure_time' => $departureDateTime,
            'arrival_time' => $arrivalDateTime,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diupdate.');
    }

    /**
     * Remove the specified schedule
     */
    public function destroy(Schedule $schedule)
    {
        try {
            $schedule->delete();
            return redirect()->route('admin.schedules.index')
                ->with('success', 'Jadwal berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.schedules.index')
                ->with('error', 'Jadwal tidak dapat dihapus karena masih memiliki tiket.');
        }
    }
}
