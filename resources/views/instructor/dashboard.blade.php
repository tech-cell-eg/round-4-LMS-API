@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    {{-- Header Row --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
<a href="{{ route('courses.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition no-underline">
    Add Course
</a>
    </div>

    {{-- Summary Cards + Sales Chart --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
        {{-- Summary Cards --}}
        <div class="lg:col-span-3 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-xl shadow-sm">
                <p class="text-sm text-gray-500 mb-1">Total Commission</p>
                <h3 class="text-2xl font-semibold text-gray-800">${{ $summary['totalCommission'] }}</h3>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-sm">
                <p class="text-sm text-gray-500 mb-1">Life Time Received Commission</p>
                <h3 class="text-2xl font-semibold text-green-600">${{ $summary['receivedCommission'] }}</h3>
            </div>
            <div class="bg-white p-4 rounded-xl shadow-sm">
                <p class="text-sm text-gray-500 mb-1">Life Time Pending </p>
                <h3 class="text-2xl font-semibold text-red-600">${{ $summary['pendingCommission'] }}</h3>
            </div>
        </div>

        {{-- Sales Chart --}}
        <div class="bg-white p-4 rounded-xl shadow-sm h-full">
            <h3 class="text-base font-semibold mb-2">Sales Timeline</h3>
            <div class="h-[220px]">
                <canvas id="salesChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

 {{-- Reviews Summary --}}


    @include('component.starrating', [
        'starCounts' => $starCounts,
        'totalReviews' => $totalReviews,
    ])


    {{-- Courses Overview --}}
    <div class="bg-white shadow rounded-xl p-6">
        <h3 class="text-lg font-semibold mb-4">Courses</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($courses as $course)
                <div class="border rounded-xl p-4 shadow-sm">
                    <h4 class="font-semibold text-gray-800 text-lg mb-2">{{ $course['title'] }}</h4>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li><strong>Price:</strong> ${{ $course['price'] }}</li>
                        <li><strong>Chapters:</strong> {{ $course['lectures'] }}</li>
                        <li><strong>Orders:</strong> {{ $course['orders_count'] }}</li>
                        <li><strong>Certificates:</strong> N/A</li>
                        <li><strong>Reviews:</strong> {{ $course['rating_count'] }}</li>
                        <li><strong>Added to Shelf:</strong> {{ $course['added_to_shelf'] }}</li>
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const salesTimeline = @json($salesTimeline);
    const labels = salesTimeline.map(entry => entry.date);
    const data = salesTimeline.map(entry => entry.total);

    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Sales',
                data: data,
                borderColor: '#4FC1E9',
                backgroundColor: 'rgba(79,193,233,0.15)',
                fill: true,
                tension: 0.4,
                pointRadius: 3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    ticks: { color: '#6B7280' },
                    grid: { display: false }
                },
                y: {
                    beginAtZero: true,
                    ticks: { color: '#6B7280' },
                    grid: { color: '#E5E7EB' }
                }
            }
        }
    });
</script>
@endsection
