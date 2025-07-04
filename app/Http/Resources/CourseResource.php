<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'image' => $this->image ?? 'default-image.jpg', // Default image if null
            'overview' => $this->overview,
            'description' => $this->description,
            'certifications' => $this->certifications,
            'languages' => $this->languages,
            'levels' => $this->levels == 1 ? 'All levels' : $this->levels,
            'price' => $this->price,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'total_hours' => $this->relationLoaded('syllabuses') ? $this->syllabuses->sum(function ($syllabus) {
                return $this->relationLoaded('lessons') ? $syllabus->lessons->sum('duration') : 0;
            }) : 0,
            'total_lectures' => $this->syllabuses->sum('lessons_count'),
            'average_rating' => $this->reviews->avg('rating') ?? 0,
            'reviews_count' => $this->reviews->count(),
            'students_count' => $this->enrollments->count(),
            'instructor' => [
                'name' => $this->instructor ? $this->instructor->first_name . ' ' . $this->instructor->last_name : 'Unknown',
                'title' => $this->instructor->title ?? 'Instructor',
                'bio' => $this->instructor->about ?? 'Unknown',
                'total_reviews' => $this->instructor->reviews()->count(),
                'total_students' => $this->instructor->courses()->withCount('enrollments')->get()->sum('enrollments_count'),
                'total_courses' => $this->instructor->courses()->count(),
            ],
            'syllabuses' => $this->syllabuses->map(function ($syllabus) {
                return [
                    'title' => $syllabus->title,
                    'description' => $syllabus->description,
                    'lessons_count' => $syllabus->lessons_count,
                    'hours' => $this->relationLoaded('lessons') ? $syllabus->lessons->sum('duration') : $syllabus->hours,
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
                    'user_name' => $review->user->name,
                    'created_at' => $review->created_at->format('jS F, Y'),
                ];
            }),
        ];
    }
}
?>