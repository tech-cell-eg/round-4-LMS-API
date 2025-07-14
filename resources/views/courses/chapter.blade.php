@extends('layouts.app')

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
        {{ session('success') }}
    </div>
@endif



@section('content')

<div class="p-6 bg-gray-50 min-h-screen">
    {{-- Header --}}
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">NCERT Solutions for Class 12 Chemistry</h2>

    {{-- Tabs Navigation --}}
    <div class="border-b border-gray-300 mb-6">
        <nav class="flex space-x-6 text-sm font-medium text-gray-600">
            <a href="{{ route('courses.commissions') }}" class="py-2 {{ request()->routeIs('courses.commissions') ? 'border-b-2 border-blue-600 text-blue-600' : 'hover:text-blue-500' }}">Commission</a>
            <a href="{{ route('courses.reviews') }}" class="py-2 hover:text-blue-500">Reviews</a>
            <a href="{{ route('courses.customer') }}" class="py-2 {{ request()->routeIs('courses.customer') ? 'border-b-2 border-blue-600 text-blue-600' : 'hover:text-blue-500' }}">Customer</a>
            <a href="{{ route('chapter') }}" class="py-2 hover:text-blue-500">Chapters</a>
            <a href="#" class="py-2 hover:text-blue-500">Promotion</a>
            <a href="#" class="py-2 hover:text-blue-500">Detail</a>
            <a href="#" class="py-2 hover:text-blue-500">Settings</a>
        </nav>
    </div>


<div class="p-6 bg-white rounded-xl shadow shadow-gray-100">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">
            Chapters List
        </h2>
    </div>

    <div class="overflow-x-auto rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 text-left text-sm font-semibold text-gray-600">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Course Price</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100 text-sm text-gray-700">
                @foreach ($chapters as $chapter)
                    @php
                    $url = route('chapterdetails', ['id' => $chapter->id]);
                    @endphp
                    <tr onclick="window.location.href='{{ $url }}'" class="hover:bg-gray-50 cursor-pointer transition">
                        <td class="px-4 py-3">#{{ $chapter->id }}</td>
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">{{ $chapter->title }}</td>
                        <td class="px-4 py-3">{{ ucfirst($chapter->type) }}</td>
                        <td class="px-4 py-3">{{ $chapter->created_at->format('d M Y h:i A') }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-1 text-xs font-medium rounded-full
                                {{ $chapter->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($chapter->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            {{ $chapter->course->price == 0 ? 'Free' : '$' . number_format($chapter->course->price, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>




@endsection
