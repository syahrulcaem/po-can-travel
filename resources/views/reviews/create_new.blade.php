@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <!-- Bus Information -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Berikan Review untuk {{ $bus->name }}</h1>
                <p class="text-gray-600">{{ $bus->plate_number }} • {{ $bus->capacity }} kursi</p>
            </div>

            <!-- Review Form -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <form method="POST" action="{{ route('reviews.store', $bus) }}">
                    @csrf

                    <!-- Rating -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Rating <span class="text-red-500">*</span>
                        </label>
                        <div class="flex space-x-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $i }}"
                                        class="hidden rating-input" {{ old('rating') == $i ? 'checked' : '' }}>
                                    <svg class="w-8 h-8 text-gray-300 hover:text-yellow-400 transition-colors rating-star"
                                        viewBox="0 0 20 20" data-rating="{{ $i }}">
                                        <path
                                            d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                    </svg>
                                </label>
                            @endfor
                        </div>
                        @error('rating')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Comment -->
                    <div class="mb-6">
                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                            Komentar (Opsional)
                        </label>
                        <textarea name="comment" id="comment" rows="4"
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $errors->has('comment') ? 'border-red-500' : 'border-gray-300' }}"
                            placeholder="Ceritakan pengalaman Anda menggunakan bus ini...">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Maksimal 1000 karakter</p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex space-x-4">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition-colors duration-200">
                            Kirim Review
                        </button>
                        <a href="{{ route('reviews.index', $bus) }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-md transition-colors duration-200">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ratingInputs = document.querySelectorAll('.rating-input');
            const ratingStars = document.querySelectorAll('.rating-star');

            // Handle star clicks
            ratingStars.forEach((star, index) => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    updateStars(rating);
                    ratingInputs[index].checked = true;
                });

                star.addEventListener('mouseenter', function() {
                    const rating = parseInt(this.dataset.rating);
                    highlightStars(rating);
                });
            });

            // Handle mouse leave
            document.querySelector('.flex.space-x-2').addEventListener('mouseleave', function() {
                const checkedInput = document.querySelector('.rating-input:checked');
                if (checkedInput) {
                    updateStars(parseInt(checkedInput.value));
                } else {
                    updateStars(0);
                }
            });

            function updateStars(rating) {
                ratingStars.forEach((star, index) => {
                    if (index < rating) {
                        star.classList.remove('text-gray-300');
                        star.classList.add('text-yellow-400', 'fill-current');
                    } else {
                        star.classList.remove('text-yellow-400', 'fill-current');
                        star.classList.add('text-gray-300');
                    }
                });
            }

            function highlightStars(rating) {
                ratingStars.forEach((star, index) => {
                    if (index < rating) {
                        star.classList.remove('text-gray-300');
                        star.classList.add('text-yellow-400', 'fill-current');
                    } else {
                        star.classList.remove('text-yellow-400', 'fill-current');
                        star.classList.add('text-gray-300');
                    }
                });
            }

            // Initialize stars based on old input
            const checkedInput = document.querySelector('.rating-input:checked');
            if (checkedInput) {
                updateStars(parseInt(checkedInput.value));
            }
        });
    </script>
@endsection
