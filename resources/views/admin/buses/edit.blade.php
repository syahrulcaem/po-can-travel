@extends('admin.layouts.app')

@section('title', 'Edit Bus')
@section('header', 'Edit Bus')

@section('content')
    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.buses.update', $bus) }}">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="grid grid-cols-1 gap-6">
                    <!-- Nama Bus -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Bus <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $bus->name) }}"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}"
                            placeholder="Contoh: Bus Ekonomi 1">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Plat Nomor -->
                    <div>
                        <label for="plate_number" class="block text-sm font-medium text-gray-700 mb-1">
                            Plat Nomor <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="plate_number" id="plate_number"
                            value="{{ old('plate_number', $bus->plate_number) }}"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('plate_number') ? 'border-red-500' : 'border-gray-300' }}"
                            placeholder="Contoh: B 1234 ABC">
                        @error('plate_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kapasitas -->
                    <div>
                        <label for="capacity" class="block text-sm font-medium text-gray-700 mb-1">
                            Kapasitas Penumpang <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $bus->capacity) }}"
                            min="1" max="100"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('capacity') ? 'border-red-500' : 'border-gray-300' }}"
                            placeholder="Contoh: 40">
                        @error('capacity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Masukkan jumlah kursi yang tersedia</p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-8 flex space-x-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition-colors duration-200">
                        Update
                    </button>
                    <a href="{{ route('admin.buses.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-md transition-colors duration-200">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
