@extends('admin.layouts.app')

@section('title', 'Konfirmasi Pembayaran')
@section('header', 'Konfirmasi Pembayaran')

@section('content')
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Pesanan Pending Konfirmasi</h3>
                <div class="text-sm text-gray-500">
                    Total: {{ $pendingOrders->total() }} pesanan
                </div>
            </div>
        </div>

        @if ($pendingOrders->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID Pesanan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pelanggan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rute
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Bukti Pembayaran
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($pendingOrders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        #{{ $order->id }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $order->order_date->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $order->user->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $order->user->email }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $firstTicket = $order->tickets->first();
                                    @endphp
                                    @if ($firstTicket && $firstTicket->schedule && $firstTicket->schedule->route)
                                        <div class="text-sm text-gray-900">
                                            {{ $firstTicket->schedule->route->origin }} →
                                            {{ $firstTicket->schedule->route->destination }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $firstTicket->schedule->departure_time->format('d/m/Y H:i') }}
                                        </div>
                                    @else
                                        <div class="text-sm text-gray-500">-</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $order->order_date->format('d/m/Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $order->order_date->format('H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $order->tickets->count() }} tiket
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($order->payment_proof)
                                        <div class="flex flex-col space-y-1">
                                            <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 px-2 py-1 rounded text-xs text-center transition-colors duration-200">
                                                <i class="fas fa-eye mr-1"></i>Lihat Bukti
                                            </a>
                                            <div class="text-xs text-gray-500">
                                                {{ $order->payment_proof_uploaded_at ? $order->payment_proof_uploaded_at->format('d/m/Y H:i') : '-' }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-sm text-gray-500">
                                            <i class="fas fa-clock mr-1"></i>Belum upload
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.orders.view', $order) }}"
                                            class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 px-3 py-1 rounded-md transition-colors duration-200">
                                            Detail
                                        </a>

                                        <form method="POST" action="{{ route('admin.orders.confirm-payment', $order) }}"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="text-green-600 hover:text-green-900 bg-green-100 hover:bg-green-200 px-3 py-1 rounded-md transition-colors duration-200"
                                                onclick="return confirm('Konfirmasi pembayaran untuk pesanan #{{ $order->id }}?')">
                                                Konfirmasi
                                            </button>
                                        </form>

                                        <button type="button"
                                            class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 px-3 py-1 rounded-md transition-colors duration-200"
                                            onclick="openRejectModal({{ $order->id }})">
                                            Tolak
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $pendingOrders->links() }}
            </div>
        @else
            <div class="p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pesanan pending</h3>
                <p class="mt-1 text-sm text-gray-500">Semua pesanan sudah dikonfirmasi atau dibatalkan.</p>
            </div>
        @endif
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900">Tolak Pembayaran</h3>
                <div class="mt-4">
                    <form id="rejectForm" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="reason" class="block text-sm font-medium text-gray-700 mb-2 text-left">
                                Alasan penolakan:
                            </label>
                            <textarea name="reason" id="reason" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="Masukkan alasan penolakan pembayaran..." required></textarea>
                        </div>
                        <div class="flex space-x-3">
                            <button type="button" onclick="closeRejectModal()"
                                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition-colors duration-200">
                                Batal
                            </button>
                            <button type="submit"
                                class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                                Tolak Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(orderId) {
            document.getElementById('rejectForm').action = `/admin/orders/${orderId}/reject-payment`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('reason').value = '';
        }

        // Close modal when clicking outside
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    </script>
@endsection
