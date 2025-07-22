@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen">
        <!-- Header -->
        <div class="gradient-bg text-white py-12">
            <div class="max-w-7xl mx-auto px-4">
                <h1 class="text-3xl font-bold text-center">
                    <i class="fas fa-ticket-alt mr-3"></i>
                    Tiket Saya
                </h1>
                <p class="text-center text-gray-200 mt-2">Kelola semua pemesanan tiket Anda</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($orders->count() > 0)
                <!-- Orders List -->
                <div class="space-y-6">
                    @foreach ($orders as $order)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover">
                            <div class="p-6">
                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-4">
                                            <div
                                                class="bg-purple-100 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                                <i class="fas fa-bus text-purple-600 text-xl"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-800">
                                                    Order #{{ $order->id }}
                                                </h3>
                                                <p class="text-gray-600">
                                                    {{ $order->order_date->format('d M Y, H:i') }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Tickets Details -->
                                        <div class="space-y-3">
                                            @foreach ($order->tickets as $ticket)
                                                <div class="border border-gray-200 rounded-lg p-4">
                                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                        <div>
                                                            <h4 class="font-semibold text-gray-800">
                                                                {{ $ticket->schedule->route->origin }} →
                                                                {{ $ticket->schedule->route->destination }}
                                                            </h4>
                                                            <p class="text-gray-600">{{ $ticket->schedule->bus->name }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-700">
                                                                <i class="fas fa-calendar mr-2"></i>
                                                                {{ $ticket->schedule->departure_time->format('d M Y') }}
                                                            </p>
                                                            <p class="text-gray-700">
                                                                <i class="fas fa-clock mr-2"></i>
                                                                {{ $ticket->schedule->departure_time->format('H:i') }} -
                                                                {{ $ticket->schedule->arrival_time->format('H:i') }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-700">
                                                                <i class="fas fa-chair mr-2"></i>
                                                                Kursi {{ $ticket->seat_number }}
                                                            </p>
                                                            <p class="font-semibold text-purple-600">
                                                                Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="mt-6 lg:mt-0 lg:ml-6 lg:text-right">
                                        <!-- Status Badge -->
                                        <div class="mb-4">
                                            @if ($order->status == 'pending')
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-clock mr-2"></i> Menunggu
                                                </span>
                                            @elseif($order->status == 'confirmed')
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                    <i class="fas fa-check mr-2"></i> Dikonfirmasi
                                                </span>
                                            @elseif($order->status == 'completed')
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-2"></i> Selesai
                                                </span>
                                            @elseif($order->status == 'cancelled')
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-times mr-2"></i> Dibatalkan
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Total Amount -->
                                        <div class="mb-4">
                                            <p class="text-gray-600 text-sm">Total Pembayaran</p>
                                            <p class="text-2xl font-bold text-gray-800">
                                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                            </p>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex flex-col space-y-2">
                                            @if ($order->status == 'pending' && !$order->payment_proof)
                                                <!-- Upload Payment Proof Form -->
                                                <form action="{{ route('orders.upload-payment-proof', $order) }}"
                                                    method="POST" enctype="multipart/form-data" class="space-y-2">
                                                    @csrf
                                                    <div>
                                                        <label for="payment_proof_{{ $order->id }}"
                                                            class="block text-sm font-medium text-gray-700 mb-1">Upload
                                                            Bukti Pembayaran</label>
                                                        <input type="file" name="payment_proof"
                                                            id="payment_proof_{{ $order->id }}" accept="image/*"
                                                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                                            required>
                                                        @error('payment_proof')
                                                            <span class="text-red-600 text-sm">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <button type="submit"
                                                        class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300">
                                                        <i class="fas fa-upload mr-2"></i>
                                                        Upload Bukti Pembayaran
                                                    </button>
                                                </form>
                                            @elseif ($order->status == 'pending' && $order->payment_proof)
                                                <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-lg text-center">
                                                    <i class="fas fa-clock mr-2"></i>
                                                    Bukti pembayaran sudah diupload<br>
                                                    <small>Menunggu konfirmasi admin</small>
                                                </div>
                                                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank"
                                                    class="w-full bg-gray-100 text-gray-800 px-4 py-2 rounded-lg text-center hover:bg-gray-200 transition duration-300">
                                                    <i class="fas fa-eye mr-2"></i>
                                                    Lihat Bukti Pembayaran
                                                </a>
                                            @endif

                                            @if ($order->canBeCanceled())
                                                <form action="{{ route('orders.cancel', $order) }}" method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="w-full bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300">
                                                        <i class="fas fa-times mr-2"></i>
                                                        Batalkan Pesanan
                                                    </button>
                                                </form>
                                            @endif

                                            @php
                                                $firstTicket = $order->tickets->first();
                                                $isCompleted =
                                                    $order->status == 'completed' ||
                                                    ($order->status == 'confirmed' &&
                                                        $firstTicket &&
                                                        $firstTicket->schedule &&
                                                        $firstTicket->schedule->departure_time->isPast());
                                            @endphp
                                            @if ($isCompleted)
                                                @php
                                                    $busId =
                                                        $firstTicket && $firstTicket->schedule
                                                            ? $firstTicket->schedule->bus_id
                                                            : null;
                                                    $bus = $busId ? \App\Models\Bus::find($busId) : null;
                                                    $userReview = $bus
                                                        ? \App\Models\Review::where('user_id', auth()->id())
                                                            ->where('bus_id', $bus->id)
                                                            ->first()
                                                        : null;
                                                @endphp
                                                @if ($bus && !$userReview)
                                                    <a href="{{ route('reviews.create', $bus) }}"
                                                        class="w-full bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-300 text-center">
                                                        <i class="fas fa-star mr-2"></i>
                                                        Beri Review
                                                    </a>
                                                @elseif($userReview)
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('reviews.index', $bus) }}"
                                                            class="flex-1 bg-green-100 text-green-800 px-4 py-2 rounded-lg text-center hover:bg-green-200 transition duration-300">
                                                            <i class="fas fa-star mr-2"></i>
                                                            Lihat Review
                                                        </a>
                                                        <a href="{{ route('reviews.edit', $bus) }}"
                                                            class="flex-1 bg-blue-100 text-blue-800 px-4 py-2 rounded-lg text-center hover:bg-blue-200 transition duration-300">
                                                            <i class="fas fa-edit mr-2"></i>
                                                            Edit Review
                                                        </a>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="bg-gray-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-ticket-alt text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Pesanan</h3>
                    <p class="text-gray-600 mb-6">Anda belum memiliki pesanan tiket. Mulai perjalanan pertama Anda
                        sekarang!
                    </p>
                    <a href="{{ route('search') }}"
                        class="btn-gradient px-6 py-3 rounded-lg font-semibold inline-flex items-center">
                        <i class="fas fa-search mr-2"></i>
                        Cari Tiket Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
