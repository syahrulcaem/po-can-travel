<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ticket;
use App\Models\Schedule;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()->orders()
            ->with(['tickets.schedule.bus', 'tickets.schedule.route'])
            ->latest()
            ->paginate(10);

        return response()->json([
            'data' => $orders->items(),
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
            ]
        ]);
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            DB::beginTransaction();

            $schedule = Schedule::findOrFail($request->input('schedule_id'));
            $tickets = $request->input('tickets');

            // Validate seat availability
            $availableSeats = $schedule->availableSeats();
            foreach ($tickets as $ticket) {
                if (!in_array($ticket['seat_number'], $availableSeats)) {
                    return response()->json([
                        'message' => "Kursi {$ticket['seat_number']} tidak tersedia"
                    ], 422);
                }
            }

            $totalAmount = count($tickets) * $schedule->price;

            $order = Order::create([
                'user_id' => $request->user()->id,
                'order_date' => now(),
                'status' => 'pending',
                'total_amount' => $totalAmount,
            ]);

            foreach ($tickets as $ticketData) {
                Ticket::create([
                    'order_id' => $order->id,
                    'schedule_id' => $schedule->id,
                    'seat_number' => $ticketData['seat_number'],
                    'price' => $schedule->price,
                    'status' => 'active',
                ]);
            }

            DB::commit();

            $order->load(['tickets.schedule.bus', 'tickets.schedule.route']);

            return response()->json([
                'message' => 'Pemesanan berhasil dibuat',
                'data' => $order
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Terjadi kesalahan saat membuat pemesanan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Order $order, Request $request)
    {
        if ($order->getAttribute('user_id') !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $order->load(['tickets.schedule.bus', 'tickets.schedule.route']);

        return response()->json(['data' => $order]);
    }

    public function cancel(Order $order, Request $request)
    {
        if ($order->getAttribute('user_id') !== $request->user()->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk membatalkan pesanan ini.');
        }

        if (!$order->canBeCanceled()) {
            return redirect()->back()->with('error', 'Pemesanan tidak dapat dibatalkan. Mungkin sudah terlalu dekat dengan waktu keberangkatan.');
        }

        try {
            DB::beginTransaction();

            $order->update([
                'status' => 'cancelled',
                'canceled_at' => now(),
            ]);

            $order->tickets()->update([
                'status' => 'cancelled',
                'canceled_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Pemesanan berhasil dibatalkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membatalkan pemesanan. Silakan coba lagi.');
        }
    }

    public function indexWeb(Request $request)
    {
        $orders = $request->user()->orders()
            ->with(['tickets.schedule.bus', 'tickets.schedule.route'])
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function create(Schedule $schedule)
    {
        $schedule->load(['bus', 'route']);
        $availableSeats = $schedule->availableSeats();

        return view('orders.create', compact('schedule', 'availableSeats'));
    }

    public function storeWeb(StoreOrderRequest $request)
    {
        $result = $this->store($request);
        $data = json_decode($result->getContent(), true);

        if ($result->getStatusCode() === 201) {
            return redirect()->route('orders.index')->with('success', $data['message']);
        }

        return redirect()->back()->with('error', $data['message'])->withInput();
    }

    public function uploadPaymentProof(Request $request, Order $order)
    {
        // Validasi bahwa user adalah pemilik order
        if ($order->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengupload bukti pembayaran untuk pesanan ini.');
        }

        // Validasi bahwa order masih pending
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Bukti pembayaran hanya dapat diupload untuk pesanan dengan status pending.');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            // Upload file
            $file = $request->file('payment_proof');
            $filename = 'payment_proof_' . $order->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('payment_proofs', $filename, 'public');

            // Update order
            $order->update([
                'payment_proof' => $path,
                'payment_proof_uploaded_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload. Pesanan Anda akan segera dikonfirmasi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupload bukti pembayaran. Silakan coba lagi.');
        }
    }
}
