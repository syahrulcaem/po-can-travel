@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Bus Header -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="md:flex">
                <!-- Bus Image -->
                <div class="md:w-1/3">
                    <div class="h-64 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                        <div class="text-white text-center">
                            <svg class="w-20 h-20 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm9-1a1 1 0 100 2h1a1 1 0 100-2h-1z" />
                            </svg>
                            <p class="text-xl font-semibold">{{ $bus->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Bus Info -->
                <div class="md:w-2/3 p-8">
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $bus->name }}</h1>
                        <p class="text-gray-600 text-lg">{{ $bus->plate_number }}</p>
                    </div>

                    <!-- Specifications -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Spesifikasi</h3>
                            <ul class="space-y-1 text-gray-600">
                                <li>Kapasitas: {{ $bus->capacity }} kursi</li>
                                <li>Nomor Polisi: {{ $bus->plate_number }}</li>
                            </ul>
                        </div>

                        <!-- Rating Summary -->
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Rating & Review</h3>
                            @if ($totalReviews > 0)
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400 mr-3">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= round($averageRating))
                                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <span
                                        class="text-lg font-semibold text-gray-900">{{ number_format($averageRating, 1) }}</span>
                                </div>
                                <p class="text-gray-600">{{ $totalReviews }} review{{ $totalReviews > 1 ? 's' : '' }}</p>
                            @else
                                <p class="text-gray-600">Belum ada review</p>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('reviews.index', $bus) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition-colors duration-200">
                            Lihat Semua Review
                        </a>
                        @auth
                            @php
                                $hasCompletedTrip = \App\Models\Order::where('user_id', auth()->id())
                                    ->whereHas('tickets.schedule', function ($query) use ($bus) {
                                        $query->where('bus_id', $bus->id);
                                    })
                                    ->where('payment_status', 'confirmed')
                                    ->exists();
                                $userReview = \App\Models\Review::where('user_id', auth()->id())
                                    ->where('bus_id', $bus->id)
                                    ->first();
                            @endphp
                            @if ($hasCompletedTrip && !$userReview)
                                <a href="{{ route('reviews.create', $bus) }}"
                                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-md transition-colors duration-200">
                                    Tulis Review
                                </a>
                            @elseif($userReview)
                                <a href="{{ route('reviews.edit', $bus) }}"
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-6 rounded-md transition-colors duration-200">
                                    Edit Review
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Schedules -->
        @if ($recentSchedules->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Jadwal Terdekat</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($recentSchedules as $schedule)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-2">
                                {{ $schedule->route->origin }} → {{ $schedule->route->destination }}
                            </h4>
                            <div class="text-sm text-gray-600 space-y-1">
                                <p>{{ $schedule->departure_time->format('d M Y') }}</p>
                                <p>{{ $schedule->departure_time->format('H:i') }} -
                                    {{ $schedule->arrival_time->format('H:i') }} WIB</p>
                                <p class="font-semibold text-gray-900">Rp
                                    {{ number_format($schedule->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Recent Reviews -->
        @if ($bus->reviews->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-900">Review Terbaru</h2>
                    <a href="{{ route('reviews.index', $bus) }}" class="text-blue-600 hover:text-blue-800">
                        Lihat Semua →
                    </a>
                </div>

                <div class="space-y-4">
                    @foreach ($bus->reviews->take(3) as $review)
                        <div class="border-b border-gray-200 pb-4 last:border-b-0">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-gray-600 text-sm font-semibold">
                                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $review->user->name }}</h4>
                                        <div class="flex text-yellow-400">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                                        <path
                                                            d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-3 h-3 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                        <path
                                                            d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                    </svg>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <span class="text-gray-500 text-sm">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            @if ($review->comment)
                                <p class="text-gray-700 text-sm">{{ Str::limit($review->comment, 150) }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
