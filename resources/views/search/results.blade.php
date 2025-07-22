@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen">
        <!-- Header -->
        <div class="gradient-bg text-white py-12">
            <div class="max-w-7xl mx-auto px-4">
                <h1 class="text-3xl font-bold text-center">
                    <i class="fas fa-search mr-3"></i>
                    Hasil Pencarian
                </h1>
                <p class="text-center text-gray-200 mt-2">
                    {{ $searchCriteria['origin'] }} → {{ $searchCriteria['destination'] }} •
                    {{ date('d M Y', strtotime($searchCriteria['departure_date'])) }}
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- Search Form (Mini) -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <form action="{{ route('search.schedules') }}" method="POST" class="flex flex-wrap gap-4 items-end">
                    @csrf
                    <div class="flex-1 min-w-48">
                        <select name="origin" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Dari</option>
                            <option value="Jakarta" {{ $searchCriteria['origin'] == 'Jakarta' ? 'selected' : '' }}>Jakarta
                            </option>
                            <option value="Bandung" {{ $searchCriteria['origin'] == 'Bandung' ? 'selected' : '' }}>Bandung
                            </option>
                            <option value="Yogyakarta" {{ $searchCriteria['origin'] == 'Yogyakarta' ? 'selected' : '' }}>
                                Yogyakarta</option>
                            <option value="Surabaya" {{ $searchCriteria['origin'] == 'Surabaya' ? 'selected' : '' }}>
                                Surabaya</option>
                            <option value="Semarang" {{ $searchCriteria['origin'] == 'Semarang' ? 'selected' : '' }}>
                                Semarang</option>
                            <option value="Solo" {{ $searchCriteria['origin'] == 'Solo' ? 'selected' : '' }}>Solo</option>
                        </select>
                    </div>
                    <div class="flex-1 min-w-48">
                        <select name="destination" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Ke</option>
                            <option value="Jakarta" {{ $searchCriteria['destination'] == 'Jakarta' ? 'selected' : '' }}>
                                Jakarta</option>
                            <option value="Bandung" {{ $searchCriteria['destination'] == 'Bandung' ? 'selected' : '' }}>
                                Bandung</option>
                            <option value="Yogyakarta"
                                {{ $searchCriteria['destination'] == 'Yogyakarta' ? 'selected' : '' }}>Yogyakarta</option>
                            <option value="Surabaya" {{ $searchCriteria['destination'] == 'Surabaya' ? 'selected' : '' }}>
                                Surabaya</option>
                            <option value="Semarang" {{ $searchCriteria['destination'] == 'Semarang' ? 'selected' : '' }}>
                                Semarang</option>
                            <option value="Solo" {{ $searchCriteria['destination'] == 'Solo' ? 'selected' : '' }}>Solo
                            </option>
                        </select>
                    </div>
                    <div class="flex-1 min-w-40">
                        <input type="date" name="departure_date" required min="{{ date('Y-m-d') }}"
                            value="{{ $searchCriteria['departure_date'] }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                    </div>
                    <div>
                        <button type="submit" class="btn-gradient px-6 py-2 rounded-lg font-semibold">
                            <i class="fas fa-search mr-2"></i>
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results -->
            @if ($schedules->count() > 0)
                <div class="mb-4">
                    <p class="text-gray-600">
                        <i class="fas fa-info-circle mr-2"></i>
                        Ditemukan {{ $schedules->count() }} jadwal tersedia
                    </p>
                </div>

                <div class="space-y-4">
                    @foreach ($schedules as $schedule)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover">
                            <div class="p-6">
                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                    <!-- Bus Info -->
                                    <div class="flex-1">
                                        <div class="flex items-center mb-4">
                                            <div
                                                class="bg-purple-100 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                                <i class="fas fa-bus text-purple-600 text-xl"></i>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-800">{{ $schedule->bus->name }}
                                                </h3>
                                                <p class="text-gray-600">{{ $schedule->bus->plate_number }}</p>
                                            </div>
                                        </div>

                                        <!-- Route Info -->
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                            <div>
                                                <p class="text-sm text-gray-600">Keberangkatan</p>
                                                <p class="font-semibold">{{ $schedule->departure_time->format('H:i') }}</p>
                                                <p class="text-sm text-gray-600">{{ $schedule->route->origin }}</p>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-sm text-gray-600">Durasi Perjalanan</p>
                                                <div class="flex items-center justify-center my-2">
                                                    <div class="border-t border-gray-300 flex-1"></div>
                                                    <i class="fas fa-bus mx-2 text-gray-400"></i>
                                                    <div class="border-t border-gray-300 flex-1"></div>
                                                </div>
                                                <p class="text-sm text-gray-600">{{ $schedule->route->distance }} km</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm text-gray-600">Kedatangan</p>
                                                <p class="font-semibold">{{ $schedule->arrival_time->format('H:i') }}</p>
                                                <p class="text-sm text-gray-600">{{ $schedule->route->destination }}</p>
                                            </div>
                                        </div>

                                        <!-- Availability -->
                                        <div class="flex items-center space-x-4 text-sm">
                                            <span class="flex items-center text-green-600">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                {{ $schedule->available_seats_count }} kursi tersedia
                                            </span>
                                            <span class="flex items-center text-gray-600">
                                                <i class="fas fa-users mr-1"></i>
                                                {{ $schedule->bus->capacity }} total kursi
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Price & Action -->
                                    <div class="mt-6 lg:mt-0 lg:ml-6 lg:text-right">
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-600">Harga per orang</p>
                                            <p class="text-2xl font-bold text-purple-600">
                                                Rp {{ number_format($schedule->price, 0, ',', '.') }}
                                            </p>
                                        </div>

                                        @if ($schedule->available_seats_count > 0)
                                            @auth
                                                <a href="{{ route('orders.create', $schedule) }}"
                                                    class="btn-gradient px-6 py-3 rounded-lg font-semibold inline-flex items-center">
                                                    <i class="fas fa-shopping-cart mr-2"></i>
                                                    Pilih Kursi
                                                </a>
                                            @else
                                                <div class="text-center">
                                                    <p class="text-gray-600 text-sm mb-2">Login untuk memesan</p>
                                                    <a href="{{ route('login') }}"
                                                        class="btn-gradient px-6 py-3 rounded-lg font-semibold inline-flex items-center">
                                                        <i class="fas fa-sign-in-alt mr-2"></i>
                                                        Login
                                                    </a>
                                                </div>
                                            @endauth
                                        @else
                                            <button disabled
                                                class="bg-gray-400 text-white px-6 py-3 rounded-lg font-semibold cursor-not-allowed">
                                                <i class="fas fa-times mr-2"></i>
                                                Penuh
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No Results -->
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <div class="bg-gray-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Tidak Ada Jadwal Ditemukan</h3>
                    <p class="text-gray-600 mb-6">
                        Maaf, tidak ada jadwal bus untuk rute {{ $searchCriteria['origin'] }} →
                        {{ $searchCriteria['destination'] }}
                        pada tanggal {{ date('d M Y', strtotime($searchCriteria['departure_date'])) }}
                    </p>
                    <div class="space-x-4">
                        <a href="{{ route('search') }}"
                            class="btn-gradient px-6 py-3 rounded-lg font-semibold inline-flex items-center">
                            <i class="fas fa-search mr-2"></i>
                            Cari Lagi
                        </a>
                        <a href="{{ route('home') }}"
                            class="border border-purple-600 text-purple-600 px-6 py-3 rounded-lg font-semibold inline-flex items-center hover:bg-purple-50 transition duration-300">
                            <i class="fas fa-home mr-2"></i>
                            Beranda
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
