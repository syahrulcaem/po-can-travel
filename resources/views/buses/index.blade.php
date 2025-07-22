@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Armada Bus Kami</h1>
            <p class="text-gray-600">Lihat rating dan review dari penumpang untuk setiap bus</p>
        </div>

        @if ($buses->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($buses as $bus)
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <!-- Bus Image Placeholder -->
                        <div class="h-48 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                            <div class="text-white text-center">
                                <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm9-1a1 1 0 100 2h1a1 1 0 100-2h-1z" />
                                </svg>
                                <p class="font-semibold">{{ $bus->name }}</p>
                            </div>
                        </div>

                        <div class="p-6">
                            <!-- Bus Info -->
                            <div class="mb-4">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $bus->name }}</h3>
                                <p class="text-gray-600 mb-1">{{ $bus->plate_number }}</p>
                                <p class="text-gray-600">{{ $bus->capacity }} kursi</p>
                            </div>

                            <!-- Rating -->
                            <div class="mb-4">
                                @if ($bus->reviews_count > 0)
                                    <div class="flex items-center mb-2">
                                        <div class="flex text-yellow-400 mr-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= round($bus->reviews_avg_rating))
                                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                        <path
                                                            d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                        <path
                                                            d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                    </svg>
                                                @endif
                                            @endfor
                                        </div>
                                        <span
                                            class="text-sm font-medium text-gray-900">{{ number_format($bus->reviews_avg_rating, 1) }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $bus->reviews_count }}
                                        review{{ $bus->reviews_count > 1 ? 's' : '' }}</p>
                                @else
                                    <div class="flex items-center mb-2">
                                        <div class="flex text-gray-300 mr-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600">Belum ada review</p>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-2">
                                <a href="{{ route('buses.show', $bus) }}"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-md transition-colors duration-200">
                                    Detail Bus
                                </a>
                                <a href="{{ route('reviews.index', $bus) }}"
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-md transition-colors duration-200">
                                    Lihat Review
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($buses->hasPages())
                <div class="mt-8">
                    {{ $buses->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <div class="text-gray-500 text-lg">
                    Belum ada armada bus yang tersedia
                </div>
            </div>
        @endif
    </div>
@endsection
