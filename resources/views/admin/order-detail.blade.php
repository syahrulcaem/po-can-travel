@extends('admin.layouts.app')

@section('title', 'Detail Pesanan #' . $order->id)
@section('header', 'Detail Pesanan #' . $order->id)

@section('content')
    <div class="space-y-6">
        <!-- Order Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Pesanan</h3>
                <span
                    class="px-3 py-1 rounded-full text-sm font-medium
                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                {{ $order->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                {{ !in_array($order->status, ['pending', 'confirmed', 'cancelled']) ? 'bg-gray-100 text-gray-800' : '' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Informasi Umum</h4>
                    <dl class="space-y-2">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">ID Pesanan:</dt>
                            <dd class="text-sm font-medium text-gray-900">#{{ $order->id }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Tanggal Pesanan:</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $order->order_date->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Total Amount:</dt>
                            <dd class="text-sm font-medium text-gray-900">Rp
                                {{ number_format($order->total_amount, 0, ',', '.') }}</dd>
                        </div>
                        @if ($order->canceled_at)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Dibatalkan:</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $order->canceled_at->format('d/m/Y H:i') }}
                                </dd>
                            </div>
                        @endif
                        @if ($order->cancellation_reason)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-600">Alasan Pembatalan:</dt>
                                <dd class="text-sm font-medium text-gray-900">{{ $order->cancellation_reason }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-500 mb-2">Informasi Pelanggan</h4>
                    <dl class="space-y-2">
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Nama:</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $order->user->name }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Email:</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $order->user->email }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-gray-600">Bergabung:</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $order->user->created_at->format('d/m/Y') }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Tickets Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Tiket</h3>

            @if ($order->tickets->count() > 0)
                <div class="space-y-4">
                    @foreach ($order->tickets as $ticket)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Rute</h4>
                                    @if ($ticket->schedule && $ticket->schedule->route)
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $ticket->schedule->route->origin }} →
                                            {{ $ticket->schedule->route->destination }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ $ticket->schedule->route->distance }} km
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-500">Data rute tidak tersedia</p>
                                    @endif
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Jadwal</h4>
                                    @if ($ticket->schedule)
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $ticket->schedule->departure_time->format('d/m/Y') }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ $ticket->schedule->departure_time->format('H:i') }} -
                                            {{ $ticket->schedule->arrival_time->format('H:i') }}
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-500">Data jadwal tidak tersedia</p>
                                    @endif
                                </div>

                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 mb-2">Bus & Kursi</h4>
                                    @if ($ticket->schedule && $ticket->schedule->bus)
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $ticket->schedule->bus->license_plate }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ $ticket->schedule->bus->bus_type }} - Kursi {{ $ticket->seat_number }}
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-500">Data bus tidak tersedia</p>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">Nama Penumpang</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $order->user->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-600">Harga</p>
                                        <p class="text-sm font-medium text-gray-900">Rp
                                            {{ number_format($ticket->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500">Tidak ada tiket untuk pesanan ini.</p>
            @endif
        </div>

        <!-- Actions -->
        @if ($order->status === 'pending')
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                <div class="flex space-x-4">
                    <form method="POST" action="{{ route('admin.orders.confirm-payment', $order) }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-md transition-colors duration-200"
                            onclick="return confirm('Konfirmasi pembayaran untuk pesanan #{{ $order->id }}?')">
                            Konfirmasi Pembayaran
                        </button>
                    </form>

                    <button type="button"
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-md transition-colors duration-200"
                        onclick="openRejectModal()">
                        Tolak Pembayaran
                    </button>
                </div>
            </div>
        @endif

        <!-- Navigation -->
        <div class="flex justify-between">
            <a href="{{ route('admin.payment.confirmations') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded transition-colors duration-200">
                ← Kembali ke Daftar
            </a>
        </div>
    </div>

    @if ($order->status === 'pending')
        <!-- Reject Modal -->
        <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg font-medium text-gray-900">Tolak Pembayaran</h3>
                    <div class="mt-4">
                        <form method="POST" action="{{ route('admin.orders.reject-payment', $order) }}">
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
            function openRejectModal() {
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
    @endif
@endsection
