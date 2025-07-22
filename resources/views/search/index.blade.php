@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen">
        <!-- Header -->
        <div class="gradient-bg text-white py-12">
            <div class="max-w-7xl mx-auto px-4">
                <h1 class="text-3xl font-bold text-center">
                    <i class="fas fa-search mr-3"></i>
                    Cari Tiket Bus
                </h1>
                <p class="text-center text-gray-200 mt-2">Temukan jadwal bus yang sesuai dengan kebutuhan Anda</p>
            </div>
        </div>

        <!-- Search Form -->
        <div class="max-w-4xl mx-auto px-4 -mt-6">
            <div class="bg-white rounded-lg shadow-xl p-6">
                <form action="{{ route('search.schedules') }}" method="POST" id="searchForm">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-2 text-purple-600"></i>
                                Dari
                            </label>
                            <select name="origin" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                                <option value="">Pilih Kota Asal</option>
                                @foreach ($routes->unique('origin') as $route)
                                    <option value="{{ $route->origin }}"
                                        {{ old('origin') == $route->origin ? 'selected' : '' }}>
                                        {{ $route->origin }}
                                    </option>
                                @endforeach
                            </select>
                            @error('origin')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-2 text-purple-600"></i>
                                Ke
                            </label>
                            <select name="destination" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                                <option value="">Pilih Kota Tujuan</option>
                                @foreach ($routes->unique('destination') as $route)
                                    <option value="{{ $route->destination }}"
                                        {{ old('destination') == $route->destination ? 'selected' : '' }}>
                                        {{ $route->destination }}
                                    </option>
                                @endforeach
                            </select>
                            @error('destination')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar mr-2 text-purple-600"></i>
                                Tanggal Keberangkatan
                            </label>
                            <input type="date" name="departure_date" required min="{{ date('Y-m-d') }}"
                                value="{{ old('departure_date', date('Y-m-d')) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                            @error('departure_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full btn-gradient px-6 py-3 rounded-lg font-semibold transition duration-300 hover:shadow-lg">
                                <i class="fas fa-search mr-2"></i>
                                Cari Jadwal
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search Results -->
        <div id="searchResults" class="max-w-7xl mx-auto px-4 py-8">
            <!-- Results will be loaded here via AJAX or page reload -->
        </div>

        <!-- Popular Routes Section -->
        <div class="max-w-7xl mx-auto px-4 py-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                <i class="fas fa-route mr-2 text-purple-600"></i>
                Rute Populer
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($routes->take(6) as $route)
                    <div class="bg-white rounded-lg shadow-md p-6 card-hover cursor-pointer"
                        onclick="selectRoute('{{ $route->origin }}', '{{ $route->destination }}')">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center text-gray-700">
                                <div class="text-center">
                                    <i class="fas fa-map-marker-alt text-purple-600"></i>
                                    <p class="font-semibold">{{ $route->origin }}</p>
                                </div>
                                <div class="mx-4">
                                    <i class="fas fa-arrow-right text-gray-400"></i>
                                </div>
                                <div class="text-center">
                                    <i class="fas fa-map-marker-alt text-purple-600"></i>
                                    <p class="font-semibold">{{ $route->destination }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center text-sm text-gray-600">
                            <span>
                                <i class="fas fa-route mr-1"></i>
                                {{ $route->distance }} km
                            </span>
                            <span class="btn-gradient text-white px-3 py-1 rounded-full text-xs">
                                Pilih Rute
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tips Section -->
        <div class="bg-white py-12">
            <div class="max-w-4xl mx-auto px-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                    <i class="fas fa-lightbulb mr-2 text-yellow-500"></i>
                    Tips Pemesanan
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start">
                        <div class="bg-purple-100 w-10 h-10 rounded-full flex items-center justify-center mr-4 mt-1">
                            <i class="fas fa-clock text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2">Pesan Lebih Awal</h3>
                            <p class="text-gray-600">Booking tiket H-1 atau lebih awal untuk mendapatkan kursi terbaik</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="bg-purple-100 w-10 h-10 rounded-full flex items-center justify-center mr-4 mt-1">
                            <i class="fas fa-mobile-alt text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2">Simpan E-Tiket</h3>
                            <p class="text-gray-600">Screenshot atau download e-tiket Anda untuk kemudahan saat naik bus</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="bg-purple-100 w-10 h-10 rounded-full flex items-center justify-center mr-4 mt-1">
                            <i class="fas fa-id-card text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2">Bawa Identitas</h3>
                            <p class="text-gray-600">Jangan lupa membawa KTP atau identitas resmi saat perjalanan</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="bg-purple-100 w-10 h-10 rounded-full flex items-center justify-center mr-4 mt-1">
                            <i class="fas fa-shield-alt text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold mb-2">Asuransi Perjalanan</h3>
                            <p class="text-gray-600">Semua tiket dilengkapi dengan asuransi perjalanan untuk keamanan Anda
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectRoute(origin, destination) {
            document.querySelector('select[name="origin"]').value = origin;
            document.querySelector('select[name="destination"]').value = destination;

            // Scroll to form
            document.getElementById('searchForm').scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            // Highlight the form briefly
            const form = document.getElementById('searchForm').parentElement;
            form.classList.add('ring-4', 'ring-purple-300');
            setTimeout(() => {
                form.classList.remove('ring-4', 'ring-purple-300');
            }, 2000);
        }

        // Auto-submit form when all fields are filled
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('searchForm');
            const selects = form.querySelectorAll('select, input[type="date"]');

            selects.forEach(select => {
                select.addEventListener('change', function() {
                    const origin = form.querySelector('select[name="origin"]').value;
                    const destination = form.querySelector('select[name="destination"]').value;
                    const date = form.querySelector('input[name="departure_date"]').value;

                    if (origin && destination && date && origin !== destination) {
                        // Optional: Auto-submit when all fields are filled
                        // form.submit();
                    }
                });
            });
        });
    </script>
@endsection
