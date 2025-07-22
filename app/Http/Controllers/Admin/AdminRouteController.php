<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminRouteController extends Controller
{
    /**
     * Display a listing of routes
     */
    public function index(): View
    {
        $routes = Route::latest()->paginate(10);
        return view('admin.routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new route
     */
    public function create(): View
    {
        return view('admin.routes.create');
    }

    /**
     * Store a newly created route
     */
    public function store(Request $request)
    {
        $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'distance' => 'required|integer|min:1',
        ]);

        Route::create($request->all());

        return redirect()->route('admin.routes.index')
            ->with('success', 'Rute berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified route
     */
    public function edit(Route $route): View
    {
        return view('admin.routes.edit', compact('route'));
    }

    /**
     * Update the specified route
     */
    public function update(Request $request, Route $route)
    {
        $request->validate([
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'distance' => 'required|integer|min:1',
        ]);

        $route->update($request->all());

        return redirect()->route('admin.routes.index')
            ->with('success', 'Rute berhasil diupdate.');
    }

    /**
     * Remove the specified route
     */
    public function destroy(Route $route)
    {
        try {
            $route->delete();
            return redirect()->route('admin.routes.index')
                ->with('success', 'Rute berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.routes.index')
                ->with('error', 'Rute tidak dapat dihapus karena masih memiliki jadwal.');
        }
    }
}
