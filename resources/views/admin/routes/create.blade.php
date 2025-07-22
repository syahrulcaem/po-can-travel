@extends('admin.layouts.app')

@section('title', 'Tambah Rute')
@section('header', 'Tambah Rute')

@section('content')
    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.routes.store') }}">
            @csrf

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="grid grid-cols-1 gap-6">
                    <!-- Asal -->
                    <div>
                        <label for="origin" class="block text-sm font-medium text-gray-700 mb-1">
                            Kota Asal <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="origin" id="origin" value="{{ old('origin') }}"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('origin') ? 'border-red-500' : 'border-gray-300' }}"
                            placeholder="Contoh: Jakarta">
                        @error('origin')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tujuan -->
                    <div>
                        <label for="destination" class="block text-sm font-medium text-gray-700 mb-1">
                            Kota Tujuan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="destination" id="destination" value="{{ old('destination') }}"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('destination') ? 'border-red-500' : 'border-gray-300' }}"
                            placeholder="Contoh: Bandung">
                        @error('destination')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jarak -->
                    <div>
                        <label for="distance" class="block text-sm font-medium text-gray-700 mb-1">
                            Jarak (KM) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="distance" id="distance" value="{{ old('distance') }}" min="1"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('distance') ? 'border-red-500' : 'border-gray-300' }}"
                            placeholder="Contoh: 150">
                        @error('distance')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Masukkan jarak dalam kilometer</p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-8 flex space-x-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition-colors duration-200">
                        Simpan
                    </button>
                    <a href="{{ route('admin.routes.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-md transition-colors duration-200">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
