<div class="bg-white shadow rounded-xl p-5 mb-5">
        <h3 class="text-base font-semibold mb-4">Reviews Overview</h3>
        <div class="grid grid-cols-2 sm:grid-cols-6 text-center gap-3">
            <div class="col-span-2 sm:col-span-1 bg-gray-50 rounded-lg p-4 border">
                <p class="text-gray-500 text-sm mb-1">Total Reviews</p>
                <h4 class="text-xl font-bold text-blue-600">{{ $totalReviews }}</h4>
            </div>

            @foreach ($starCounts as $star => $count)
                <div class="bg-gray-50 rounded-lg p-4 border">
                    <p class="text-gray-500 text-sm mb-1">{{ $star }} Star Reviews</p>
                    <h4 class="text-base font-bold text-gray-800">{{ $count }}</h4>
                    <div class="flex justify-center mt-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $star ? 'text-yellow-400' : 'text-gray-300' }} fill-current" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09L5.4 12.18.522 7.91l6.588-.957L10 1l2.89 5.953 6.588.957-4.878 4.27 1.278 5.91z"/>
                            </svg>
                        @endfor
                    </div>
                </div>
            @endforeach
        </div>
    </div>