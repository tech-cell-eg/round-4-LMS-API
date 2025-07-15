@extends('layouts.app')

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




    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white p-4 rounded-xl shadow-sm">
            <div class="text-sm text-gray-500 mb-1">Life Time Courses Commission</div>
            <div class="text-2xl font-semibold text-gray-800">${{ $totalCommission }}</div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm">
            <div class="text-sm text-gray-500 mb-1">Life Time Received Commission</div>
        <div class="text-2xl font-semibold text-green-600">${{ $receivedCommission }}</div>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-sm">
            <div class="text-sm text-gray-500 mb-1">Life Time Pending Commission</div>
           <div class="text-2xl font-semibold text-red-600">${{ $pendingCommission }}</div>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto bg-white shadow rounded-xl">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commission</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-700">
                @forelse ($commissions as $row)
                    <tr>
                        <td class="px-6 py-4">#{{ $row['order_id'] }}</td>
                        <td class="px-6 py-4">{{ $row['customer'] }}</td>
                        <td class="px-6 py-4">{{ $row['type'] }}</td>
                        <td class="px-6 py-4">{{ $row['date'] }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $row['status'] == 'Received' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $row['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">${{ $row['commission'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-400">No commission data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center mt-6">
        <nav class="inline-flex items-center space-x-1">
            <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-100">«</a>
            <a href="#" class="px-3 py-1 rounded bg-blue-600 text-white">1</a>
            <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-100">2</a>
            <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-100">3</a>
            <a href="#" class="px-3 py-1 rounded border border-gray-300 text-gray-600 hover:bg-gray-100">»</a>
        </nav>
    </div>
</div>
@endsection
