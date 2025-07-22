@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen">
        <!-- Header -->
        <div class="gradient-bg text-white py-12">
            <div class="max-w-7xl mx-auto px-4">
                <h1 class="text-3xl font-bold text-center">
                    <i class="fas fa-star mr-3"></i>
                    Beri Review
                </h1>
                <p class="text-center text-gray-200 mt-2">Bagikan pengalaman perjalanan Anda</p>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 py-8">
            <!-- Order Information -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Perjalanan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-100 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-bus text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold">{{ $order->schedule->bus->name }}</h4>
                                <p class="text-gray-600 text-sm">{{ $order->schedule->bus->plate_number }}</p>
                            </div>
                        </div>

                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nomor Pesanan:</span>
                                <span class="font-semibold">{{ $order->order_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Perjalanan:</span>
                                @php
                                    $firstTicket = $order->tickets->first();
                                @endphp
                                <span class="font-semibold">
                                    {{ $firstTicket && $firstTicket->schedule ? $firstTicket->schedule->departure_time->format('d M Y') : 'N/A' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jumlah Tiket:</span>
                                <span class="font-semibold">{{ $order->ticket_quantity }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Keberangkatan</p>
                                <p class="font-semibold">{{ $order->schedule->departure_time->format('H:i') }}</p>
                                <p class="text-sm text-gray-600">{{ $order->schedule->route->origin }}</p>
                            </div>
                            <div class="flex-1 mx-4">
                                <div class="border-t border-gray-300 relative">
                                    <i
                                        class="fas fa-bus absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white text-gray-400 px-2"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Kedatangan</p>
                                <p class="font-semibold">{{ $order->schedule->arrival_time->format('H:i') }}</p>
                                <p class="text-sm text-gray-600">{{ $order->schedule->route->destination }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Form -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Tulis Review Anda</h3>

                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="bus_id" value="{{ $order->schedule->bus_id }}">

                    <!-- Rating -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            <i class="fas fa-star text-yellow-400 mr-2"></i>
                            Rating
                        </label>
                        <div class="flex items-center space-x-2">
                            <div id="rating-stars" class="flex space-x-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="button"
                                        class="star-btn text-gray-300 hover:text-yellow-400 text-2xl transition-colors duration-200"
                                        data-rating="{{ $i }}">
                                        <i class="fas fa-star"></i>
                                    </button>
                                @endfor
                            </div>
                            <span id="rating-text" class="text-gray-600 ml-4">Pilih rating</span>
                        </div>
                        <input type="hidden" name="rating" id="rating-input" required>
                        @error('rating')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Comment -->
                    <div class="mb-6">
                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-3">
                            <i class="fas fa-comment text-purple-600 mr-2"></i>
                            Komentar
                        </label>
                        <textarea name="comment" id="comment" rows="5" required placeholder="Ceritakan pengalaman perjalanan Anda..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500 resize-none">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Review Categories -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            <i class="fas fa-check-circle text-green-600 mr-2"></i>
                            Aspek yang Dinilai
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="border border-gray-200 rounded-lg p-4 text-center">
                                <i class="fas fa-chair text-purple-600 text-2xl mb-2"></i>
                                <p class="text-sm font-medium">Kenyamanan Kursi</p>
                            </div>
                            <div class="border border-gray-200 rounded-lg p-4 text-center">
                                <i class="fas fa-clock text-blue-600 text-2xl mb-2"></i>
                                <p class="text-sm font-medium">Ketepatan Waktu</p>
                            </div>
                            <div class="border border-gray-200 rounded-lg p-4 text-center">
                                <i class="fas fa-user-tie text-green-600 text-2xl mb-2"></i>
                                <p class="text-sm font-medium">Pelayanan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit"
                            class="btn-gradient px-8 py-3 rounded-lg font-semibold flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Review
                        </button>

                        <a href="{{ route('orders.index') }}"
                            class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold flex items-center justify-center hover:bg-gray-50 transition duration-300">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Pesanan
                        </a>
                    </div>
                </form>
            </div>

            <!-- Review Tips -->
            <div class="bg-blue-50 rounded-lg p-6 mt-6">
                <h4 class="font-semibold text-blue-800 mb-3">
                    <i class="fas fa-lightbulb mr-2"></i>
                    Tips Menulis Review yang Baik
                </h4>
                <ul class="text-blue-700 text-sm space-y-2">
                    <li class="flex items-start">
                        <i class="fas fa-check text-blue-600 mr-2 mt-0.5 text-xs"></i>
                        Berikan penilaian yang jujur dan objektif
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-blue-600 mr-2 mt-0.5 text-xs"></i>
                        Ceritakan pengalaman spesifik selama perjalanan
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-blue-600 mr-2 mt-0.5 text-xs"></i>
                        Sertakan saran untuk perbaikan jika ada
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-blue-600 mr-2 mt-0.5 text-xs"></i>
                        Gunakan bahasa yang sopan dan konstruktif
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-btn');
            const ratingInput = document.getElementById('rating-input');
            const ratingText = document.getElementById('rating-text');

            const ratingLabels = {
                1: 'Sangat Buruk',
                2: 'Buruk',
                3: 'Cukup',
                4: 'Baik',
                5: 'Sangat Baik'
            };

            stars.forEach((star, index) => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);

                    // Update input value
                    ratingInput.value = rating;

                    // Update visual stars
                    stars.forEach((s, i) => {
                        if (i < rating) {
                            s.classList.remove('text-gray-300');
                            s.classList.add('text-yellow-400');
                        } else {
                            s.classList.remove('text-yellow-400');
                            s.classList.add('text-gray-300');
                        }
                    });

                    // Update rating text
                    ratingText.textContent = ratingLabels[rating];
                });

                // Hover effect
                star.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.dataset.rating);
                    stars.forEach((s, i) => {
                        if (i < rating) {
                            s.classList.add('text-yellow-400');
                            s.classList.remove('text-gray-300');
                        }
                    });
                });
            });

            // Reset to selected rating on mouse leave
            document.getElementById('rating-stars').addEventListener('mouseleave', function() {
                const currentRating = parseInt(ratingInput.value) || 0;
                stars.forEach((s, i) => {
                    if (i < currentRating) {
                        s.classList.add('text-yellow-400');
                        s.classList.remove('text-gray-300');
                    } else {
                        s.classList.remove('text-yellow-400');
                        s.classList.add('text-gray-300');
                    }
                });
            });
        });
    </script>
@endsection
