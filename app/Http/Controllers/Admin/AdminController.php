<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard(): View
    {
        $pendingOrders = Order::where('status', 'pending')->count();
        $confirmedOrders = Order::where('status', 'confirmed')->count();
        $totalRevenue = Order::where('status', 'confirmed')->sum('total_amount');
        $totalUsers = User::count();

        return view('admin.dashboard', compact(
            'pendingOrders',
            'confirmedOrders',
            'totalRevenue',
            'totalUsers'
        ));
    }

    /**
     * Display pending payment confirmations
     */
    public function paymentConfirmations(): View
    {
        $pendingOrders = Order::with(['user', 'tickets' => function ($query) {
            $query->with(['schedule' => function ($scheduleQuery) {
                $scheduleQuery->with(['route', 'bus']);
            }]);
        }])
            ->where('status', 'pending')
            ->orderBy('order_date', 'desc')
            ->paginate(10);

        return view('admin.payment-confirmations', compact('pendingOrders'));
    }

    /**
     * Confirm payment for an order
     */
    public function confirmPayment(Request $request, Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Order sudah dikonfirmasi atau dibatalkan');
        }

        $order->update(['status' => 'confirmed']);

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi');
    }

    /**
     * Reject payment for an order
     */
    public function rejectPayment(Request $request, Order $order)
    {
        $request->validate([
            'reason' => 'required|string|max:255'
        ]);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Order sudah dikonfirmasi atau dibatalkan');
        }

        $order->update([
            'status' => 'cancelled',
            'canceled_at' => now(),
            'cancellation_reason' => $request->reason
        ]);

        return back()->with('success', 'Pembayaran ditolak dan order dibatalkan');
    }

    /**
     * View order details
     */
    public function viewOrder(Order $order): View
    {
        $order->load(['user', 'tickets' => function ($query) {
            $query->with(['schedule' => function ($scheduleQuery) {
                $scheduleQuery->with(['route', 'bus']);
            }]);
        }]);

        return view('admin.order-detail', compact('order'));
    }
}
