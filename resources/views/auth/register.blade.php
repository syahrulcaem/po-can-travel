@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div class="bg-primary-light w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-plus text-primary text-3xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Baru</h1>
                <p class="text-gray-600">Bergabunglah dengan PO CAN Travel</p>
            </div>

            <!-- Card -->
            <div class="card card-hover">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Lengkap
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                autofocus autocomplete="name"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-200 @error('name') border-red-300 ring-red-100 @enderror"
                                placeholder="Masukkan nama lengkap">
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autocomplete="username"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-200 @error('email') border-red-300 ring-red-100 @enderror"
                                placeholder="Masukkan email Anda">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor Telepon
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-gray-400"></i>
                            </div>
                            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" required
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-200 @error('phone') border-red-300 ring-red-100 @enderror"
                                placeholder="Contoh: 08123456789">
                        </div>
                        @error('phone')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-200 @error('password') border-red-300 ring-red-100 @enderror"
                                placeholder="Minimal 8 karakter">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Konfirmasi Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                autocomplete="new-password"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-200"
                                placeholder="Konfirmasi password">
                        </div>
                    </div>

                    <!-- Terms Agreement -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" type="checkbox" name="terms" required
                                class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary">
                        </div>
                        <div class="ml-3">
                            <label for="terms" class="text-sm text-gray-600">
                                Saya menyetujui
                                <a href="#" class="text-primary hover:text-blue-800 font-semibold">Syarat &
                                    Ketentuan</a>
                                dan
                                <a href="#" class="text-primary hover:text-blue-800 font-semibold">Kebijakan
                                    Privasi</a>
                            </label>
                        </div>
                    </div>

                    <!-- Register Button -->
                    <button type="submit"
                        class="w-full btn-orange py-3 px-4 rounded-lg font-semibold text-white text-center">
                        <i class="fas fa-user-plus mr-2"></i>
                        Buat Akun Sekarang
                    </button>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500">atau</span>
                        </div>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-gray-600">
                            Sudah punya akun?
                            <a href="{{ route('login') }}"
                                class="font-semibold text-primary hover:text-blue-800 transition duration-200">
                                Masuk sekarang
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Additional Info -->
            <div class="mt-8 text-center">
                <div class="bg-blue-50 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-primary mb-2">Mengapa bergabung dengan PO CAN Travel?</h3>
                    <div class="text-xs text-gray-600 space-y-1">
                        <p>✓ Booking tiket bus mudah dan cepat</p>
                        <p>✓ Harga transparan tanpa biaya tersembunyi</p>
                        <p>✓ Customer service 24/7</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
