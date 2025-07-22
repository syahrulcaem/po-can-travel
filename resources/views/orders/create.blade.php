@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 min-h-screen">
        <!-- Header -->
        <div class="gradient-bg text-white py-12">
            <div class="max-w-7xl mx-auto px-4">
                <h1 class="text-3xl font-bold text-center">
                    <i class="fas fa-shopping-cart mr-3"></i>
                    Pesan Tiket
                </h1>
                <p class="text-center text-gray-200 mt-2">Pilih kursi dan selesaikan pemesanan Anda</p>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 py-8">
            <!-- Schedule Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    <i class="fas fa-info-circle mr-2 text-purple-600"></i>
                    Detail Jadwal
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Informasi Rute</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt mr-3 text-purple-600 w-4"></i>
                                <span>{{ $schedule->route->origin }} → {{ $schedule->route->destination }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-route mr-3 text-purple-600 w-4"></i>
                                <span>{{ $schedule->route->distance }} km</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-800 mb-2">Informasi Bus</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <i class="fas fa-bus mr-3 text-purple-600 w-4"></i>
                                <span>{{ $schedule->bus->name }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-id-card mr-3 text-purple-600 w-4"></i>
                                <span>{{ $schedule->bus->plate_number }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-users mr-3 text-purple-600 w-4"></i>
                                <span>{{ $schedule->bus->capacity }} kursi</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center">
                            <p class="text-gray-600">Tanggal Keberangkatan</p>
                            <p class="font-semibold text-lg">{{ $schedule->departure_time->format('d M Y') }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-600">Waktu Keberangkatan</p>
                            <p class="font-semibold text-lg">{{ $schedule->departure_time->format('H:i') }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-gray-600">Harga per Tiket</p>
                            <p class="font-semibold text-lg text-purple-600">Rp
                                {{ number_format($schedule->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seat Selection -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    <i class="fas fa-chair mr-2 text-purple-600"></i>
                    Pilih Kursi
                </h2>

                <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                    @csrf
                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                    <!-- Seat Map -->
                    <div class="mb-6">
                        <div class="max-w-md mx-auto">
                            <!-- Driver -->
                            <div class="flex justify-end mb-4">
                                <div class="bg-gray-800 text-white px-4 py-2 rounded-lg">
                                    <i class="fas fa-steering-wheel mr-2"></i>
                                    Supir
                                </div>
                            </div>

                            <!-- Seats -->
                            <div class="grid grid-cols-4 gap-2">
                                @for ($i = 1; $i <= $schedule->bus->capacity; $i++)
                                    @php
                                        $isAvailable = in_array($i, $availableSeats);
                                    @endphp
                                    <button type="button"
                                        class="seat-btn aspect-square rounded-lg border-2 font-semibold text-sm transition duration-300
                                               {{ $isAvailable ? 'border-green-300 bg-green-100 text-green-800 hover:bg-green-200' : 'border-red-300 bg-red-100 text-red-800 cursor-not-allowed' }}"
                                        data-seat="{{ $i }}" {{ !$isAvailable ? 'disabled' : '' }}>
                                        {{ $i }}
                                    </button>
                                @endfor
                            </div>

                            <!-- Legend -->
                            <div class="mt-6 flex justify-center space-x-4 text-sm">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-green-100 border border-green-300 rounded mr-2"></div>
                                    <span>Tersedia</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-red-100 border border-red-300 rounded mr-2"></div>
                                    <span>Terisi</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-purple-100 border border-purple-300 rounded mr-2"></div>
                                    <span>Dipilih</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Selected Seats -->
                    <div id="selectedSeats" class="mb-6 hidden">
                        <h3 class="font-semibold text-gray-800 mb-2">Kursi yang Dipilih:</h3>
                        <div id="seatsList" class="flex flex-wrap gap-2"></div>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-gray-800 mb-2">Ringkasan Pesanan</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span>Jumlah Tiket:</span>
                                <span id="ticketCount">0</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Harga per Tiket:</span>
                                <span>Rp {{ number_format($schedule->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between font-semibold text-lg border-t pt-2">
                                <span>Total:</span>
                                <span id="totalAmount">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" id="submitBtn" disabled
                            class="btn-gradient px-8 py-3 rounded-lg font-semibold disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-credit-card mr-2"></i>
                            Pesan Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedSeats = [];
            const ticketPrice = {{ $schedule->price }};

            // Seat selection
            document.querySelectorAll('.seat-btn:not([disabled])').forEach(btn => {
                btn.addEventListener('click', function() {
                    const seatNumber = this.dataset.seat;

                    if (selectedSeats.includes(seatNumber)) {
                        // Remove seat
                        selectedSeats = selectedSeats.filter(seat => seat !== seatNumber);
                        this.classList.remove('border-purple-300', 'bg-purple-100',
                            'text-purple-800');
                        this.classList.add('border-green-300', 'bg-green-100', 'text-green-800');
                    } else {
                        // Add seat
                        selectedSeats.push(seatNumber);
                        this.classList.remove('border-green-300', 'bg-green-100', 'text-green-800');
                        this.classList.add('border-purple-300', 'bg-purple-100', 'text-purple-800');
                    }

                    updateOrderSummary();
                });
            });

            function updateOrderSummary() {
                const ticketCount = selectedSeats.length;
                const totalAmount = ticketCount * ticketPrice;

                document.getElementById('ticketCount').textContent = ticketCount;
                document.getElementById('totalAmount').textContent = 'Rp ' + totalAmount.toLocaleString('id-ID');

                // Update selected seats display
                const selectedSeatsDiv = document.getElementById('selectedSeats');
                const seatsList = document.getElementById('seatsList');

                if (ticketCount > 0) {
                    selectedSeatsDiv.classList.remove('hidden');
                    seatsList.innerHTML = selectedSeats.map(seat =>
                        `<span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">Kursi ${seat}</span>`
                    ).join('');

                    document.getElementById('submitBtn').disabled = false;
                } else {
                    selectedSeatsDiv.classList.add('hidden');
                    document.getElementById('submitBtn').disabled = true;
                }
            }

            // Form submission
            document.getElementById('orderForm').addEventListener('submit', function(e) {
                if (selectedSeats.length === 0) {
                    e.preventDefault();
                    alert('Silakan pilih minimal satu kursi!');
                    return;
                }

                // Add selected seats to form
                selectedSeats.forEach((seat, index) => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `tickets[${index}][seat_number]`;
                    input.value = seat;
                    this.appendChild(input);
                });
            });
        });
    </script>
@endsection
