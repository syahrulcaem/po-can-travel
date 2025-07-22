@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div class="bg-primary-light w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-bus text-primary text-3xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang</h1>
                <p class="text-gray-600">Masuk ke akun PO CAN Travel Anda</p>
            </div>

            <!-- Card -->
            <div class="card card-hover">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex">
                            <i class="fas fa-check-circle text-green-400 mr-3 mt-0.5"></i>
                            <p class="text-green-700 text-sm">{{ session('status') }}</p>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

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
                                autofocus autocomplete="username"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-200 @error('email') border-red-300 ring-red-100 @enderror"
                                placeholder="Masukkan email Anda">
                        </div>
                        @error('email')
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
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition duration-200 @error('password') border-red-300 ring-red-100 @enderror"
                                placeholder="Masukkan password Anda">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-primary hover:text-blue-800 font-medium">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <button type="submit"
                        class="w-full btn-orange py-3 px-4 rounded-lg font-semibold text-white text-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Masuk ke Akun
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

                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-gray-600">
                            Belum punya akun?
                            <a href="{{ route('register') }}"
                                class="font-semibold text-primary hover:text-blue-800 transition duration-200">
                                Daftar sekarang
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Additional Options -->
            <div class="mt-8 text-center">
                <p class="text-xs text-gray-500">
                    Dengan masuk, Anda menyetujui
                    <a href="#" class="text-primary hover:text-blue-800">Syarat & Ketentuan</a>
                    dan
                    <a href="#" class="text-primary hover:text-blue-800">Kebijakan Privasi</a>
                </p>
            </div>
        </div>
    </div>
@endsection
