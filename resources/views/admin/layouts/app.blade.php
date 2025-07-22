<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Additional CSS -->
    <style>
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.375rem;
        }

        .active-link {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 0.375rem;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="sidebar w-64 text-white flex-shrink-0">
            <div class="p-6">
                <h1 class="text-2xl font-bold">Admin Panel</h1>
                <p class="text-gray-200 text-sm">PO Can Travel</p>
            </div>

            <nav class="mt-8 px-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="sidebar-link flex items-center py-3 px-4 text-white hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'active-link' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.payment.confirmations') }}"
                            class="sidebar-link flex items-center py-3 px-4 text-white hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.payment.confirmations') ? 'active-link' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Konfirmasi Pembayaran
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.buses.index') }}"
                            class="sidebar-link flex items-center py-3 px-4 text-white hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.buses.*') ? 'active-link' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2v0a2 2 0 01-2 2H8a2 2 0 01-2-2v0a2 2 0 01-2-2V9a2 2 0 012-2h2z">
                                </path>
                            </svg>
                            Kelola Bus
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.routes.index') }}"
                            class="sidebar-link flex items-center py-3 px-4 text-white hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.routes.*') ? 'active-link' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 013.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                </path>
                            </svg>
                            Kelola Rute
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.schedules.index') }}"
                            class="sidebar-link flex items-center py-3 px-4 text-white hover:text-white transition-colors duration-200 {{ request()->routeIs('admin.schedules.*') ? 'active-link' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Kelola Jadwal
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="absolute bottom-0 w-64 p-4">
                <div class="bg-white bg-opacity-20 rounded-lg p-3">
                    <p class="text-sm text-gray-200">{{ Auth::guard('admin')->user()->name }}</p>
                    <form method="POST" action="{{ route('admin.logout') }}" class="mt-2">
                        @csrf
                        <button type="submit"
                            class="text-xs text-gray-300 hover:text-white transition-colors duration-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4">
                    <h2 class="text-2xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h2>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                        role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
