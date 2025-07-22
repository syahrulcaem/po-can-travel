<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold mb-2">Selamat datang, {{ auth()->user()->name }}!</h3>
                        <p class="text-gray-600">Anda berhasil login ke sistem PO Can Travel.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                        <!-- Card Ganti Password (inline form) -->
                        <div
                            class="bg-green-50 border border-green-200 rounded-lg p-6 flex flex-col items-start shadow-sm w-full">
                            <div class="flex items-center mb-3">
                                <svg class="w-8 h-8 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 11c0-1.105.895-2 2-2s2 .895 2 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2a2 2 0 012-2zm0 0V7a4 4 0 118 0v4" />
                                </svg>
                                <span class="font-semibold text-lg text-green-700">Ganti Password</span>
                            </div>
                            <p class="text-gray-700 mb-4">Ubah password akun Anda untuk keamanan lebih baik.</p>
                            @if (session('status_password'))
                                <div class="mb-3 text-green-700 bg-green-100 border border-green-300 rounded px-3 py-2">
                                    {{ session('status_password') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('profile.password.update') }}" class="w-full">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="current_password"
                                        class="block text-sm font-medium text-gray-700">Password Lama</label>
                                    <input type="password" name="current_password" id="current_password" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    @error('current_password')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="block text-sm font-medium text-gray-700">Password
                                        Baru</label>
                                    <input type="password" name="password" id="password" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    @error('password')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation"
                                        class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                </div>
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md transition-colors duration-200 w-full">Simpan
                                    Password Baru</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
