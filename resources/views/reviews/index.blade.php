@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Bus Information -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $bus->name }}</h1>
                    <p class="text-gray-600">{{ $bus->plate_number }} • {{ $bus->capacity }} kursi</p>
                </div>
                <div class="text-right">
                    @if ($totalReviews > 0)
                        <div class="flex items-center mb-2">
                            <div class="flex text-yellow-400 mr-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($averageRating))
                                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-lg font-semibold">{{ number_format($averageRating, 1) }}</span>
                        </div>
                        <p class="text-gray-600">{{ $totalReviews }} review{{ $totalReviews > 1 ? 's' : '' }}</p>
                    @else
                        <p class="text-gray-600">Belum ada review</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        @if ($canReview)
            <div class="mb-6">
                @if ($userReview)
                    <div class="flex space-x-4">
                        <a href="{{ route('reviews.edit', $bus) }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition-colors duration-200">
                            Edit Review Saya
                        </a>
                        <form method="POST" action="{{ route('reviews.destroy', $bus) }}" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus review ini?')"
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md transition-colors duration-200">
                                Hapus Review
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('reviews.create', $bus) }}"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md transition-colors duration-200">
                        Tulis Review
                    </a>
                @endif
            </div>
        @endif

        <!-- Success/Error Messages -->
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

        @if (session('info'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-6">
                {{ session('info') }}
            </div>
        @endif

        <!-- Reviews List -->
        <div class="bg-white rounded-lg shadow-md">
            @if ($reviews->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach ($reviews as $review)
                        <div class="p-6 {{ $review->user_id == auth()->id() ? 'bg-blue-50' : '' }}">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center mr-4">
                                        <span class="text-gray-600 font-semibold">
                                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">
                                            {{ $review->user->name }}
                                            @if ($review->user_id == auth()->id())
                                                <span class="text-blue-600 text-sm">(Anda)</span>
                                            @endif
                                        </h4>
                                        <div class="flex text-yellow-400 mt-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
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
                                    </div>
                                </div>
                                <span class="text-gray-500 text-sm">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            @if ($review->comment)
                                <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($reviews->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $reviews->links() }}
                    </div>
                @endif
            @else
                <div class="p-12 text-center">
                    <div class="text-gray-500 text-lg mb-4">
                        Belum ada review untuk bus ini
                    </div>
                    @if ($canReview && !$userReview)
                        <a href="{{ route('reviews.create', $bus) }}"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md transition-colors duration-200">
                            Jadilah yang pertama memberikan review
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection
