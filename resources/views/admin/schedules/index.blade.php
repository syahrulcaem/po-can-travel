@extends('admin.layouts.app')

@section('title', 'Manajemen Jadwal')
@section('header', 'Manajemen Jadwal')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.schedules.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition-colors duration-200">
            + Tambah Jadwal
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if ($schedules->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rute
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Bus
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal & Waktu
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kursi Tersedia
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($schedules as $schedule)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $schedule->route->origin }} → {{ $schedule->route->destination }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $schedule->route->distance }} km
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $schedule->bus->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $schedule->bus->plate_number }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $schedule->departure_time ? $schedule->departure_time->format('d M Y') : '-' }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $schedule->departure_time ? $schedule->departure_time->format('H:i') : '-' }} -
                                        {{ $schedule->arrival_time ? $schedule->arrival_time->format('H:i') : '-' }} WIB
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Rp {{ number_format($schedule->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $bookedTickets = $schedule->tickets()->where('status', 'confirmed')->count();
                                        $availableSeats = $schedule->bus->capacity - $bookedTickets;
                                    @endphp
                                    <div class="text-sm text-gray-900">
                                        {{ $availableSeats }}/{{ $schedule->bus->capacity }}
                                    </div>
                                    @if ($availableSeats == 0)
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Penuh
                                        </span>
                                    @elseif($availableSeats <= 5)
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Hampir Penuh
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Tersedia
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.schedules.edit', $schedule) }}"
                                        class="text-blue-600 hover:text-blue-900 transition-colors duration-200">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.schedules.destroy', $schedule) }}"
                                        class="inline-block"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($schedules->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $schedules->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-12 text-center">
                <div class="text-gray-500 text-lg mb-4">
                    Belum ada jadwal yang tersedia
                </div>
                <a href="{{ route('admin.schedules.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition-colors duration-200">
                    Tambah Jadwal Pertama
                </a>
            </div>
        @endif
    </div>
@endsection
