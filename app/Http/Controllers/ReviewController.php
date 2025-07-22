<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Bus;
use App\Http\Requests\StoreReviewRequest;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $busId = $request->input('bus_id');

        $query = Review::with(['user', 'bus']);

        if ($busId) {
            $query->where('bus_id', $busId);
        }

        $reviews = $query->latest()->paginate(10);

        return response()->json([
            'data' => $reviews->items(),
            'pagination' => [
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
                'per_page' => $reviews->perPage(),
                'total' => $reviews->total(),
            ]
        ]);
    }

    public function store(StoreReviewRequest $request)
    {
        // Check if user has already reviewed this bus
        $existingReview = Review::where('user_id', $request->user()->id)
            ->where('bus_id', $request->input('bus_id'))
            ->first();

        if ($existingReview) {
            return response()->json([
                'message' => 'Anda sudah memberikan review untuk bus ini'
            ], 422);
        }

        // Check if user has used this bus
        $hasUsedBus = $request->user()->orders()
            ->whereHas('tickets.schedule', function ($query) use ($request) {
                $query->where('bus_id', $request->input('bus_id'));
            })
            ->where('status', 'completed')
            ->exists();

        if (!$hasUsedBus) {
            return response()->json([
                'message' => 'Anda hanya bisa memberikan review untuk bus yang pernah Anda gunakan'
            ], 422);
        }

        $review = Review::create([
            'user_id' => $request->user()->id,
            'bus_id' => $request->input('bus_id'),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        $review->load(['user', 'bus']);

        return response()->json([
            'message' => 'Review berhasil ditambahkan',
            'data' => $review
        ], 201);
    }

    public function show(Review $review)
    {
        $review->load(['user', 'bus']);

        return response()->json(['data' => $review]);
    }

    public function update(StoreReviewRequest $request, Review $review)
    {
        if ($review->getAttribute('user_id') !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $review->update($request->validated());
        $review->load(['user', 'bus']);

        return response()->json([
            'message' => 'Review berhasil diupdate',
            'data' => $review
        ]);
    }

    public function destroy(Review $review, Request $request)
    {
        if ($review->getAttribute('user_id') !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $review->delete();

        return response()->json([
            'message' => 'Review berhasil dihapus'
        ]);
    }

    public function createFromOrder(Order $order)
    {
        // Pastikan order milik user yang sedang login
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to order');
        }

        // Pastikan perjalanan sudah selesai
        $firstTicket = $order->tickets()->first();
        if (!$firstTicket || !$firstTicket->schedule || $firstTicket->schedule->departure_time->isFuture()) {
            return redirect()->route('orders.index')
                ->with('error', 'Review hanya bisa dibuat setelah perjalanan selesai.');
        }

        // Pastikan belum ada review untuk order ini
        if ($order->reviews()->exists()) {
            return redirect()->route('orders.index')
                ->with('error', 'Review untuk pesanan ini sudah pernah dibuat.');
        }

        return view('reviews.create', compact('order'));
    }

    public function storeWeb(StoreReviewRequest $request)
    {
        $result = $this->store($request);
        $data = json_decode($result->getContent(), true);

        if ($result->getStatusCode() === 201) {
            return redirect()->route('home')->with('success', $data['message']);
        }

        return redirect()->back()->with('error', $data['message'])->withInput();
    }
}
