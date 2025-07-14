@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8f9fa; /* خلفية رمادي فاتح جداً */
    }

    .course-card {
        background-color: #ffffff; /* أبيض ناعم */
        border: 1px solid #dee2e6;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
        color: #495057; /* رمادي داكن */
    }

    .course-card:hover {
        transform: translateY(-4px);
    }

    .course-card h5 {
        color: #495057;
        font-weight: 600;
    }

    .course-card p {
        font-size: 0.95rem;
        color: #6c757d; /* رمادي فاتح */
        margin-bottom: 0.4rem;
    }

    .btn {
        font-weight: 500;
    }

    .container {
        background-color: #f1f3f5; /* خلفية رمادي أفتح للكونتينر */
        padding: 2rem;
        border-radius: 12px;
    }
</style>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-secondary">Courses</h2>
        <div>
            <a href="{{ route('courses.commissions') }}" class="btn btn-warning me-2">View Commissions</a>
            <a href="{{ route('courses.create') }}" class="btn btn-primary">Add Course</a>
        </div>
    </div>

    @if($courses->isEmpty())
        <div class="alert alert-warning">No courses found for this instructor.</div>
    @else
        <div class="row">
            @foreach ($courses as $course)
                <div class="col-md-4 mb-4">
                    <div class="card course-card">
                        <div class="card-body">
                            <h5>{{ $course->title }}</h5>
                            <p><strong>Price:</strong> {{ $course->price == 0 ? 'Free' : '$' . number_format($course->price, 2) }}</p>
                            <p><strong>Chapters:</strong> {{ $course->syllabuses->count() }}</p>
                            <p><strong>Orders:</strong> {{ $course->enrollments->count() }}</p>
                            <p><strong>Certificates:</strong> {{ $course->certifications }}</p>
                            <p><strong>Reviews:</strong> {{ $course->reviews->count() }}</p>
                            <p><strong>Added to shelf:</strong> {{ \App\Models\CartItem::where('course_id', $course->id)->count() }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
