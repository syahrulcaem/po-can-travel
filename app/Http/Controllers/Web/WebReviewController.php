<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Bus;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display reviews for a specific bus
     */
    public function index(Bus $bus)
    {
        $reviews = $bus->reviews()
            ->with('user')
            ->latest()
            ->paginate(10);

        $averageRating = $bus->reviews()->avg('rating');
        $totalReviews = $bus->reviews()->count();

        // Check if current user can review this bus
        $canReview = false;
        $userReview = null;

        if (Auth::check()) {
            // Check if user has taken this bus (has completed order)
            $hasCompletedTrip = Order::where('user_id', Auth::id())
                ->whereHas('tickets.schedule', function ($query) use ($bus) {
                    $query->where('bus_id', $bus->id);
                })
                ->where('payment_status', 'confirmed')
                ->exists();

            if ($hasCompletedTrip) {
                $canReview = true;
                // Check if user already reviewed this bus
                $userReview = Review::where('user_id', Auth::id())
                    ->where('bus_id', $bus->id)
                    ->first();
            }
        }

        return view('reviews.index', compact('bus', 'reviews', 'averageRating', 'totalReviews', 'canReview', 'userReview'));
    }

    /**
     * Show the form for creating a new review
     */
    public function create(Bus $bus)
    {
        // Check if user has taken this bus (has completed order)
        $hasCompletedTrip = Order::where('user_id', Auth::id())
            ->whereHas('tickets.schedule', function ($query) use ($bus) {
                $query->where('bus_id', $bus->id);
            })
            ->where('payment_status', 'confirmed')
            ->exists();

        if (!$hasCompletedTrip) {
            return redirect()->back()->with('error', 'Anda hanya bisa memberikan review setelah melakukan perjalanan dengan bus ini.');
        }

        // Check if user already reviewed this bus
        $existingReview = Review::where('user_id', Auth::id())
            ->where('bus_id', $bus->id)
            ->exists();

        if ($existingReview) {
            return redirect()->route('reviews.edit', ['bus' => $bus])->with('info', 'Anda sudah memberikan review untuk bus ini. Anda bisa mengeditnya.');
        }

        return view('reviews.create_new', compact('bus'));
    }

    /**
     * Store a newly created review
     */
    public function store(Request $request, Bus $bus)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Check if user has taken this bus
        $hasCompletedTrip = Order::where('user_id', Auth::id())
            ->whereHas('tickets.schedule', function ($query) use ($bus) {
                $query->where('bus_id', $bus->id);
            })
            ->where('payment_status', 'confirmed')
            ->exists();

        if (!$hasCompletedTrip) {
            return redirect()->back()->with('error', 'Anda hanya bisa memberikan review setelah melakukan perjalanan dengan bus ini.');
        }

        // Check if user already reviewed this bus
        $existingReview = Review::where('user_id', Auth::id())
            ->where('bus_id', $bus->id)
            ->exists();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk bus ini.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'bus_id' => $bus->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('reviews.index', $bus)->with('success', 'Review berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified review
     */
    public function edit(Bus $bus)
    {
        $review = Review::where('user_id', Auth::id())
            ->where('bus_id', $bus->id)
            ->first();

        if (!$review) {
            return redirect()->route('reviews.create', $bus)->with('error', 'Anda belum memberikan review untuk bus ini.');
        }

        return view('reviews.edit', compact('review', 'bus'));
    }

    /**
     * Update the specified review
     */
    public function update(Request $request, Bus $bus)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review = Review::where('user_id', Auth::id())
            ->where('bus_id', $bus->id)
            ->first();

        if (!$review) {
            return redirect()->back()->with('error', 'Review tidak ditemukan.');
        }

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('reviews.index', $bus)->with('success', 'Review berhasil diperbarui!');
    }

    /**
     * Remove the specified review
     */
    public function destroy(Bus $bus)
    {
        $review = Review::where('user_id', Auth::id())
            ->where('bus_id', $bus->id)
            ->first();

        if (!$review) {
            return redirect()->back()->with('error', 'Review tidak ditemukan.');
        }

        $review->delete();

        return redirect()->route('reviews.index', $bus)->with('success', 'Review berhasil dihapus!');
    }
}
