@extends('layouts.app')

@section('content')
<div class="container bg-white p-4 rounded shadow-sm">
    <h2 class="mb-4">Add New Course</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <style>
        input.form-control,
        select.form-control,
        textarea.form-control {
            background-color: #ffffff !important; /* أبيض */
            color: #212529 !important; /* أسود غامق */
            border: 1px solid #ced4da;
            border-radius: 6px;
        }

        input.form-control::placeholder,
        textarea.form-control::placeholder {
            color: #6c757d; /* رمادي فاتح */
        }

        label.form-label {
            font-weight: 500;
            color: #343a40;
        }
    </style>

    <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Course Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (leave 0 for free)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', 0) }}" required>
        </div>

        <div class="mb-3">
            <label for="overview" class="form-label">Overview</label>
            <textarea name="overview" class="form-control" rows="3">{{ old('overview') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Detailed Description</label>
            <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="certifications" class="form-label">Certifications</label>
            <textarea name="certifications" class="form-control" rows="2">{{ old('certifications') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Course Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Create Course</button>
    </form>
</div>
@endsection
