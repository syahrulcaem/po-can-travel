<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Http\Requests\StoreBusRequest;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::with('reviews')->paginate(10);

        return response()->json([
            'data' => $buses->items(),
            'pagination' => [
                'current_page' => $buses->currentPage(),
                'last_page' => $buses->lastPage(),
                'per_page' => $buses->perPage(),
                'total' => $buses->total(),
            ]
        ]);
    }

    public function store(StoreBusRequest $request)
    {
        $bus = Bus::create($request->validated());

        return response()->json([
            'message' => 'Bus berhasil ditambahkan',
            'data' => $bus
        ], 201);
    }

    public function show(Bus $bus)
    {
        $bus->load(['reviews.user', 'schedules.route']);

        return response()->json([
            'data' => $bus,
            'average_rating' => $bus->averageRating()
        ]);
    }

    public function update(StoreBusRequest $request, Bus $bus)
    {
        $bus->update($request->validated());

        return response()->json([
            'message' => 'Bus berhasil diupdate',
            'data' => $bus
        ]);
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();

        return response()->json([
            'message' => 'Bus berhasil dihapus'
        ]);
    }
}
