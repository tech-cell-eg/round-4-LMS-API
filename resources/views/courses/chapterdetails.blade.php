@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
  <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-8">

    {{-- Header Title --}}
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-gray-900">{{ $chapter->title }}</h2>
      <p class="text-gray-600 text-sm mt-1">
        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.
      </p>
    </div>

    {{-- Action Buttons --}}
    <div class="flex gap-3 mb-6">
  {{-- Delete --}}
 <form action="{{ route('chapters.toggleStatus', $chapter->id) }}" method="POST">
    @csrf
    @method('PATCH')
    @if ($chapter->status === 'published')
        <button class="px-4 py-2 text-sm font-medium text-yellow-600 border border-yellow-600 rounded hover:bg-yellow-50 transition">
            Move to Draft
        </button>
    @else
        <button class="px-4 py-2 text-sm font-medium text-green-600 border border-green-600 rounded hover:bg-green-50 transition">
            Publish
        </button>
    @endif
</form>
  <form action="{{ route('chapters.destroy', $chapter->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this chapter?');">
        @csrf
        @method('DELETE')
        <button class="px-4 py-2 text-sm font-medium text-red-600 border border-red-600 rounded hover:bg-red-50 transition">
            Delete
        </button>
    </form>

  {{-- Add Course --}}
              <a href="{{ route('courses.create') }}" class="btn btn-primary">Add Course</a>

</div>


    {{-- Tabs --}}
    <div class="flex space-x-8 border-b border-gray-200 mb-6 text-sm font-medium">
      <a href="#" class="text-blue-600 border-b-2 border-blue-600 pb-2">Details</a>
      <a href="#" class="text-gray-500 hover:text-blue-600 hover:border-blue-600 pb-2">Resources</a>
      <a href="#" class="text-gray-500 hover:text-blue-600 hover:border-blue-600 pb-2">SEO</a>
    </div>

    {{-- Chapter Details Section --}}
    <div class="space-y-6 text-gray-800 text-sm">

      {{-- Title --}}
      <div>
        <p class="text-gray-500 mb-1 font-semibold">Title</p>
        <p>{{ $chapter->title }}</p>
      </div>

      {{-- Subtitle --}}
      <div>
        <p class="text-gray-500 mb-1 font-semibold">Subtitle</p>
        <p>{{ $chapter->subtitle }}</p>
      </div>

      {{-- Description --}}
      <div>
        <p class="text-gray-500 mb-1 font-semibold">Description</p>
        <p class="leading-relaxed">
          {!! nl2br(e($chapter->description)) !!}
        </p>
      </div>

    </div>

  </div>
</div>
@endsection
