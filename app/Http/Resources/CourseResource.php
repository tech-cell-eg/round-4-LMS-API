<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray($request)
    {
        $totalDuration = $this->syllabuses->flatMap->lessons->sum('duration');
        $totalLectures = $this->syllabuses->flatMap->lessons->count();

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'image' => $this->image ?? 'default-image.jpg',
            'overview' => $this->overview,
            'description' => $this->description,
            'certifications' => $this->certifications,
            'languages' => $this->languages,
            'level' => match ((int) $this->levels) {
                0 => 'Beginner',
                1 => 'Intermediate',
                2 => 'Advanced',
                default => 'All Levels',
            },
            'price' => round($this->price, 2),
            'discount' => $this->discount,
            'tax' => $this->tax,
            'total_hours' => round($totalDuration / 60, 2),
            'total_lectures' => $totalLectures,
            'average_rating' => round($this->reviews->avg('rating'), 1) ?? 0,
            'reviews_count' => $this->reviews->count(),
            'students_count' => $this->enrollments->count(),
            'category' => $this->category?->title ?? 'Unknown',
            'instructor' => [
                'name' => $this->instructor ? $this->instructor->first_name . ' ' . $this->instructor->last_name : 'Unknown',
                'title' => $this->instructor->title ?? 'Instructor',
                'bio' => $this->instructor->about ?? '',
                'total_reviews' => $this->instructor->reviews()->count(),
                'total_students' => $this->instructor->courses()->withCount('enrollments')->get()->sum('enrollments_count'),
                'total_courses' => $this->instructor->courses()->count(),
            ],
            'syllabuses' => $this->syllabuses->map(function ($syllabus) {
                return [
                    'title' => $syllabus->title,
                    'description' => $syllabus->description,
                    'lessons_count' => $syllabus->lessons->count(),
                    'hours' => round($syllabus->lessons->sum('duration') / 60, 2),
                    'lessons' => $syllabus->lessons->map(function ($lesson) {
                        return [
                            'title' => $lesson->title,
                            'description' => $lesson->description,
                            'duration' => $lesson->duration,
                        ];
                    }),
                ];
            }),
            'reviews' => $this->reviews->take(5)->map(function ($review) {
                return [
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'user_name' => $review->user->name ?? 'Anonymous',
                    'created_at' => $review->created_at->format('jS F, Y'),
                ];
            }),
        ];
    }
}
