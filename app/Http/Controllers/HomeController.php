<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Route;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $popularRoutes = Route::withCount('schedules')
            ->orderBy('schedules_count', 'desc')
            ->limit(6)
            ->get();

        $featuredBuses = Bus::with('reviews')
            ->get()
            ->map(function ($bus) {
                $bus->average_rating = $bus->averageRating();
                return $bus;
            })
            ->sortByDesc('average_rating')
            ->take(3);

        $recentReviews = Review::with(['user', 'bus'])
            ->latest()
            ->limit(6)
            ->get();

        return view('home', compact('popularRoutes', 'featuredBuses', 'recentReviews'));
    }
}
