@extends('layouts.app')

@section('content')

<div class="px-6 pt-4 bg-gray-50 min-h-screen">
    {{-- Header --}}
    <h2 class="text-xl font-semibold text-gray-800 mb-3">NCERT Solutions for Class 12 Chemistry</h2>

    {{-- Tabs Navigation --}}
    <div class="border-b border-gray-200 mb-3">
        <nav class="flex space-x-4 text-sm font-medium text-gray-600">
            <a href="{{ route('courses.commissions') }}" class="pb-2 {{ request()->routeIs('courses.commissions') ? 'border-b-2 border-blue-600 text-blue-600' : 'hover:text-blue-500' }}">Commission</a>
            <a href="{{ route('courses.reviews') }}" class="pb-2 hover:text-blue-500">Reviews</a>
            <a href="{{ route('courses.customer') }}" class="py-2 {{ request()->routeIs('courses.customer') ? 'border-b-2 border-blue-600 text-blue-600' : 'hover:text-blue-500' }}">Customer</a>
            <a href="{{ route('chapter') }}" class="py-2 hover:text-blue-500">Chapters</a>
            <a href="#" class="pb-2 hover:text-blue-500">Promotion</a>
            <a href="#" class="pb-2 hover:text-blue-500">Detail</a>
            <a href="#" class="pb-2 hover:text-blue-500">Settings</a>
        </nav>
    </div>

    {{-- Star Rating Summary --}}
        <div class="mb-4">
        @include('component.starrating', [
            'starCounts' => $starCounts,
            'totalReviews' => $totalReviews,
        ])
 

    {{-- Reviews --}}
    <div class="space-y-3"> 
        @foreach ($reviews as $review)
        <div class="bg-white p-4 rounded-lg border border-gray-200">
            <div class="flex justify-between items-start mb-1">
                <div>
                    <p class="text-sm text-gray-700 font-semibold mb-1">
                        Course Name: <span class="font-normal">{{ $review->reviewable->title ?? '-' }}</span>
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $review->user->first_name ?? 'Unknown' }} • {{ $review->created_at->diffForHumans() }}
                    </p>
                </div>
                <div class="text-yellow-500 text-sm font-semibold">
                    ★ {{ number_format($review->rating, 1) }}
                </div>
            </div>
            <p class="text-sm text-gray-700 leading-snug">
                {{ $review->comment }}
            </p>
        </div>
        @endforeach
    </div>
</div>

<div class="mt-6">
    {{ $reviews->links() }}
</div>

@endsection
