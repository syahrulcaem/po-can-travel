<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BusController extends Controller
{
    /**
     * Display a listing of buses
     */
    public function index(): View
    {
        $buses = Bus::latest()->paginate(10);
        return view('admin.buses.index', compact('buses'));
    }

    /**
     * Show the form for creating a new bus
     */
    public function create(): View
    {
        return view('admin.buses.create');
    }

    /**
     * Store a newly created bus
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'plate_number' => 'required|string|max:255|unique:buses',
            'capacity' => 'required|integer|min:1|max:100',
        ]);

        Bus::create($request->all());

        return redirect()->route('admin.buses.index')
            ->with('success', 'Bus berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified bus
     */
    public function edit(Bus $bus): View
    {
        return view('admin.buses.edit', compact('bus'));
    }

    /**
     * Update the specified bus
     */
    public function update(Request $request, Bus $bus)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'plate_number' => 'required|string|max:255|unique:buses,plate_number,' . $bus->id,
            'capacity' => 'required|integer|min:1|max:100',
        ]);

        $bus->update($request->all());

        return redirect()->route('admin.buses.index')
            ->with('success', 'Bus berhasil diupdate.');
    }

    /**
     * Remove the specified bus
     */
    public function destroy(Bus $bus)
    {
        try {
            $bus->delete();
            return redirect()->route('admin.buses.index')
                ->with('success', 'Bus berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.buses.index')
                ->with('error', 'Bus tidak dapat dihapus karena masih memiliki jadwal.');
        }
    }
}
