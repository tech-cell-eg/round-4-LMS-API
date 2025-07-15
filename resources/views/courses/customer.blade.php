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

    {{-- Table --}}
    <div class="overflow-x-auto bg-white shadow rounded-xl">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-xs text-gray-500 uppercase">
                <tr>
                    <th class="px-6 py-3 text-left font-medium">ID</th>
                    <th class="px-6 py-3 text-left font-medium">Customer</th>
                    <th class="px-6 py-3 text-left font-medium">Type</th>
                    <th class="px-6 py-3 text-left font-medium">Country</th>
                    <th class="px-6 py-3 text-left font-medium">Joined</th>
                    <th class="px-6 py-3 text-left font-medium">Total Amount</th>
                    <th class="px-6 py-3 text-left font-medium">Last Order</th>
                    <th class="px-6 py-3 text-left font-medium">Order ID</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-700">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-800">#{{ $user['id'] }}</td>
                        <td class="px-6 py-4">{{ $user['name'] }}</td>
                        <td class="px-6 py-4 text-blue-600 font-semibold">{{ $user['type'] }}</td>
                        <td class="px-6 py-4">{{ $user['country'] }}</td>
                        <td class="px-6 py-4">{{ $user['joined'] }}</td>
                        <td class="px-6 py-4 text-green-600 font-semibold">${{ number_format($user['total_amount'], 2) }}</td>
                        <td class="px-6 py-4">{{ $user['last_order'] }}</td>
                        <td class="px-6 py-4 font-medium">#{{ $user['order_id'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-400">No customers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Placeholder --}}
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
