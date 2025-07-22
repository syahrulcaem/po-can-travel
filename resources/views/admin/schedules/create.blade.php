@extends('admin.layouts.app')

@section('title', 'Tambah Jadwal')
@section('header', 'Tambah Jadwal')

@section('content')
    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.schedules.store') }}">
            @csrf

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="grid grid-cols-1 gap-6">
                    <!-- Rute -->
                    <div>
                        <label for="route_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Rute <span class="text-red-500">*</span>
                        </label>
                        <select name="route_id" id="route_id"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('route_id') ? 'border-red-500' : 'border-gray-300' }}">
                            <option value="">Pilih Rute</option>
                            @foreach ($routes as $route)
                                <option value="{{ $route->id }}" {{ old('route_id') == $route->id ? 'selected' : '' }}>
                                    {{ $route->origin }} → {{ $route->destination }} ({{ $route->distance }} km)
                                </option>
                            @endforeach
                        </select>
                        @error('route_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bus -->
                    <div>
                        <label for="bus_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Bus <span class="text-red-500">*</span>
                        </label>
                        <select name="bus_id" id="bus_id"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('bus_id') ? 'border-red-500' : 'border-gray-300' }}">
                            <option value="">Pilih Bus</option>
                            @foreach ($buses as $bus)
                                <option value="{{ $bus->id }}" {{ old('bus_id') == $bus->id ? 'selected' : '' }}>
                                    {{ $bus->name }} - {{ $bus->plate_number }} ({{ $bus->capacity }} kursi)
                                </option>
                            @endforeach
                        </select>
                        @error('bus_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Keberangkatan -->
                    <div>
                        <label for="departure_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Tanggal Keberangkatan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="departure_date" id="departure_date" value="{{ old('departure_date') }}"
                            min="{{ date('Y-m-d') }}"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('departure_date') ? 'border-red-500' : 'border-gray-300' }}">
                        @error('departure_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Waktu Keberangkatan -->
                    <div>
                        <label for="departure_time" class="block text-sm font-medium text-gray-700 mb-1">
                            Waktu Keberangkatan <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="departure_time" id="departure_time" value="{{ old('departure_time') }}"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('departure_time') ? 'border-red-500' : 'border-gray-300' }}">
                        @error('departure_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Waktu Tiba -->
                    <div>
                        <label for="arrival_time" class="block text-sm font-medium text-gray-700 mb-1">
                            Waktu Tiba <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="arrival_time" id="arrival_time" value="{{ old('arrival_time') }}"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('arrival_time') ? 'border-red-500' : 'border-gray-300' }}">
                        @error('arrival_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                            Harga Tiket (Rp) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" min="1000"
                            step="1000"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('price') ? 'border-red-500' : 'border-gray-300' }}"
                            placeholder="Contoh: 150000">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Harga per penumpang dalam Rupiah</p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-8 flex space-x-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition-colors duration-200">
                        Simpan
                    </button>
                    <a href="{{ route('admin.schedules.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-md transition-colors duration-200">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
