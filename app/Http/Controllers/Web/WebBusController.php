<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Review;
use Illuminate\Http\Request;

class WebBusController extends Controller
{
    /**
     * Display a listing of buses with their ratings
     */
    public function index(Request $request)
    {
        $buses = Bus::withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc')
            ->paginate(12);

        return view('buses.index', compact('buses'));
    }

    /**
     * Display the specified bus with detailed info and reviews
     */
    public function show(Bus $bus)
    {
        $bus->load(['reviews.user', 'schedules.route']);

        $averageRating = $bus->reviews()->avg('rating');
        $totalReviews = $bus->reviews()->count();

        // Get recent schedules
        $recentSchedules = $bus->schedules()
            ->with('route')
            ->where('departure_time', '>=', now())
            ->orderBy('departure_time')
            ->take(5)
            ->get();

        return view('buses.show', compact('bus', 'averageRating', 'totalReviews', 'recentSchedules'));
    }
}
