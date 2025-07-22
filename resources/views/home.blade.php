@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="gradient-bg text-white">
        <div class="max-w-7xl mx-auto px-4 py-20">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Perjalanan Nyaman
                    <span class="block text-yellow-300">Dimulai dari Sini</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-gray-200">
                    Pesan tiket bus dengan mudah, cepat, dan terpercaya
                </p>
                <a href="{{ route('search') }}"
                    class="inline-flex items-center bg-white text-purple-600 px-8 py-4 rounded-full text-lg font-semibold hover:bg-gray-100 transition duration-300">
                    <i class="fas fa-search mr-3"></i>
                    Cari Tiket Sekarang
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Search -->
    <div class="max-w-7xl mx-auto px-4 -mt-10 relative z-10">
        <div class="bg-white rounded-lg shadow-xl p-6">
            <form action="{{ route('search.schedules') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dari</label>
                    <select name="origin" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Pilih Kota Asal</option>
                        @foreach ($popularRoutes as $route)
                            <option value="{{ $route->origin }}">{{ $route->origin }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ke</label>
                    <select name="destination" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Pilih Kota Tujuan</option>
                        @foreach ($popularRoutes as $route)
                            <option value="{{ $route->destination }}">{{ $route->destination }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="departure_date" required min="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full btn-gradient px-6 py-3 rounded-lg font-semibold transition duration-300">
                        <i class="fas fa-search mr-2"></i>
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Features -->
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Mengapa Memilih PO CAN Travel?</h2>
            <p class="text-gray-600 text-lg">Layanan terbaik untuk perjalanan Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center card-hover bg-white p-8 rounded-lg shadow-md">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-purple-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Pemesanan Cepat</h3>
                <p class="text-gray-600">Proses pemesanan yang mudah dan cepat dalam hitungan menit</p>
            </div>

            <div class="text-center card-hover bg-white p-8 rounded-lg shadow-md">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-purple-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Aman & Terpercaya</h3>
                <p class="text-gray-600">Keamanan data dan transaksi terjamin dengan sistem terkini</p>
            </div>

            <div class="text-center card-hover bg-white p-8 rounded-lg shadow-md">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-headset text-purple-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3">Support 24/7</h3>
                <p class="text-gray-600">Tim customer service siap membantu Anda kapan saja</p>
            </div>
        </div>
    </div>

    <!-- Popular Routes -->
    <div class="bg-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Rute Populer</h2>
                <p class="text-gray-600 text-lg">Destinasi favorit pelanggan kami</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($popularRoutes as $route)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover">
                        <div class="gradient-bg text-white p-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    {{ $route->origin }}
                                </div>
                                <div>
                                    <i class="fas fa-arrow-right mx-2"></i>
                                </div>
                                <div>
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    {{ $route->destination }}
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">
                                    <i class="fas fa-route mr-1"></i>
                                    {{ $route->distance }} km
                                </span>
                                <span class="text-purple-600 font-semibold">
                                    {{ $route->schedules_count }} jadwal
                                </span>
                            </div>
                            <a href="{{ route('search') }}"
                                class="block mt-3 btn-gradient text-center py-2 rounded-md text-white font-medium">
                                Lihat Jadwal
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Featured Buses -->
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Bus Unggulan</h2>
            <p class="text-gray-600 text-lg">Bus dengan rating terbaik dari pelanggan</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($featuredBuses as $bus)
                <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-semibold">{{ $bus->name }}</h3>
                            <div class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i
                                        class="fas fa-star {{ $i <= ($bus->average_rating ?? 0) ? 'star-rating' : 'text-gray-300' }}"></i>
                                @endfor
                                <span class="ml-2 text-gray-600">({{ number_format($bus->average_rating ?? 0, 1) }})</span>
                            </div>
                        </div>
                        <div class="space-y-2 text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-users mr-3 w-4"></i>
                                <span>{{ $bus->capacity }} kursi</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-id-card mr-3 w-4"></i>
                                <span>{{ $bus->plate_number }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-star mr-3 w-4"></i>
                                <span>{{ $bus->reviews->count() }} review</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Reviews -->
    @if ($recentReviews->count() > 0)
        <div class="bg-gray-100 py-16">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Apa Kata Pelanggan</h2>
                    <p class="text-gray-600 text-lg">Review terbaru dari pengguna PO CAN Travel</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($recentReviews as $review)
                        <div class="bg-white p-6 rounded-lg shadow-md card-hover">
                            <div class="flex items-center mb-4">
                                <div class="bg-purple-100 w-12 h-12 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-purple-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold">{{ $review->user->name }}</h4>
                                    <div class="flex items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="fas fa-star {{ $i <= $review->rating ? 'star-rating' : 'text-gray-300' }} text-sm"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-3">"{{ $review->comment }}"</p>
                            <p class="text-sm text-purple-600 font-medium">{{ $review->bus->name }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- CTA Section -->
    <div class="gradient-bg text-white py-16">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Siap untuk Perjalanan Berikutnya?</h2>
            <p class="text-xl mb-8 text-gray-200">Bergabung dengan ribuan pelanggan yang sudah mempercayai PO CAN Travel
            </p>
            <div class="space-x-4">
                <a href="{{ route('search') }}"
                    class="inline-flex items-center bg-white text-purple-600 px-8 py-4 rounded-full text-lg font-semibold hover:bg-gray-100 transition duration-300">
                    <i class="fas fa-search mr-3"></i>
                    Mulai Pencarian
                </a>
                @guest
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center border-2 border-white text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-white hover:text-purple-600 transition duration-300">
                        <i class="fas fa-user-plus mr-3"></i>
                        Daftar Gratis
                    </a>
                @endguest
            </div>
        </div>
    </div>
@endsection
