<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PO CAN Travel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a'
                        },
                        orange: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12'
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'ui-sans-serif', 'system-ui']
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
        }

        .btn-orange {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-orange:hover {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(249, 115, 22, 0.3);
        }

        .card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 1.5rem;
        }

        .text-primary {
            color: #2563eb;
        }

        .text-orange {
            color: #f97316;
        }

        .bg-primary-light {
            background-color: #eff6ff;
        }

        .border-primary {
            border-color: #3b82f6;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="gradient-bg shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center text-white font-bold text-xl">
                            <i class="fas fa-bus mr-2"></i>
                            PO CAN Travel
                        </a>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="{{ route('home') }}"
                            class="text-white hover:text-blue-100 px-3 py-2 rounded-md transition duration-200">
                            <i class="fas fa-home mr-1"></i> Beranda
                        </a>
                        <a href="{{ route('search') }}"
                            class="text-white hover:text-blue-100 px-3 py-2 rounded-md transition duration-200">
                            <i class="fas fa-search mr-1"></i> Cari Tiket
                        </a>

                        @auth
                            <a href="{{ route('orders.index') }}"
                                class="text-white hover:text-blue-100 px-3 py-2 rounded-md transition duration-200">
                                <i class="fas fa-ticket-alt mr-1"></i> Tiket Saya
                            </a>
                            <a href="{{ route('dashboard') }}"
                                class="text-white hover:text-blue-100 px-3 py-2 rounded-md transition duration-200">
                                <i class="fas fa-user mr-1"></i> {{ Auth::user()->name }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit"
                                    class="text-white hover:text-blue-100 px-3 py-2 rounded-md transition duration-200">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-white hover:text-blue-100 px-3 py-2 rounded-md transition duration-200">
                                <i class="fas fa-sign-in-alt mr-1"></i> Login
                            </a>
                            <a href="{{ route('register') }}" class="btn-orange px-6 py-2 rounded-lg font-semibold">
                                Daftar Sekarang
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button onclick="toggleMobileMenu()"
                            class="text-white hover:text-blue-100 transition duration-200">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden bg-blue-800">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('home') }}"
                        class="text-white block px-3 py-2 rounded-md hover:bg-blue-700 transition duration-200">Beranda</a>
                    <a href="{{ route('search') }}"
                        class="text-white block px-3 py-2 rounded-md hover:bg-blue-700 transition duration-200">Cari
                        Tiket</a>
                    @auth
                        <a href="{{ route('orders.index') }}"
                            class="text-white block px-3 py-2 rounded-md hover:bg-blue-700 transition duration-200">Tiket
                            Saya</a>
                        <a href="{{ route('dashboard') }}"
                            class="text-white block px-3 py-2 rounded-md hover:bg-blue-700 transition duration-200">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-white block px-3 py-2 rounded-md w-full text-left hover:bg-blue-700 transition duration-200">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-white block px-3 py-2 rounded-md hover:bg-blue-700 transition duration-200">Login</a>
                        <a href="{{ route('register') }}"
                            class="text-white block px-3 py-2 rounded-md hover:bg-blue-700 transition duration-200">Daftar</a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-4 mt-4"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-4 mt-4"
                role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            @yield('content')
            {{ $slot ?? '' }}
        </main>

        <!-- Footer -->
        <footer class="gradient-bg text-white mt-20">
            <div class="max-w-7xl mx-auto px-4 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-bold mb-4">
                            <i class="fas fa-bus mr-2"></i>
                            PO CAN Travel
                        </h3>
                        <p class="text-blue-100 leading-relaxed">Platform pemesanan tiket bus yang efisien dan
                            user-friendly untuk perjalanan yang nyaman.</p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4 text-white">Layanan</h4>
                        <ul class="space-y-3 text-blue-100">
                            <li><a href="{{ route('search') }}" class="hover:text-white transition duration-200">Cari
                                    Tiket</a></li>
                            <li><a href="#" class="hover:text-white transition duration-200">Jadwal Bus</a></li>
                            <li><a href="#" class="hover:text-white transition duration-200">Rute Populer</a></li>
                            <li><a href="#" class="hover:text-white transition duration-200">Promo Spesial</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4 text-white">Bantuan</h4>
                        <ul class="space-y-3 text-blue-100">
                            <li><a href="#" class="hover:text-white transition duration-200">FAQ</a></li>
                            <li><a href="#" class="hover:text-white transition duration-200">Pusat Bantuan</a>
                            </li>
                            <li><a href="#" class="hover:text-white transition duration-200">Kebijakan Privasi</a>
                            </li>
                            <li><a href="#" class="hover:text-white transition duration-200">Syarat &
                                    Ketentuan</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4 text-white">Kontak</h4>
                        <div class="text-blue-100 space-y-3">
                            <p class="flex items-center">
                                <i class="fas fa-phone mr-3 text-orange-400"></i>
                                0800-123-4567
                            </p>
                            <p class="flex items-center">
                                <i class="fas fa-envelope mr-3 text-orange-400"></i>
                                info@pocantravel.com
                            </p>
                            <p class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-3 text-orange-400"></i>
                                Jakarta, Indonesia
                            </p>
                            <div class="flex space-x-4 mt-6">
                                <a href="#" class="text-blue-100 hover:text-orange-400 transition duration-200">
                                    <i class="fab fa-facebook-f text-xl"></i>
                                </a>
                                <a href="#" class="text-blue-100 hover:text-orange-400 transition duration-200">
                                    <i class="fab fa-twitter text-xl"></i>
                                </a>
                                <a href="#" class="text-blue-100 hover:text-orange-400 transition duration-200">
                                    <i class="fab fa-instagram text-xl"></i>
                                </a>
                                <a href="#" class="text-blue-100 hover:text-orange-400 transition duration-200">
                                    <i class="fab fa-whatsapp text-xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-t border-blue-600 mt-8 pt-8 text-center text-blue-100">
                    <p>&copy; 2025 PO CAN Travel. Semua hak cipta dilindungi.</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>

</html>
