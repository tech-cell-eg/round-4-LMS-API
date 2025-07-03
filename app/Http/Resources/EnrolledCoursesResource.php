<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrolledCoursesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $course = $this->course;
        $user = $this->user;

        $syllabuses = $course->syllabuses ?? collect();

        $allLessons = $syllabuses->flatMap(function ($syllabus) {
            return $syllabus->lessons ?? [];
        });

        $totalLessons = $allLessons->count();
        $doneLessons = $user->Lessons->whereIn('lesson_id', $allLessons->pluck('id'))->count();

        $progress = $totalLessons > 0 ? round(($doneLessons / $totalLessons) * 100, 2) : 0;

        return [
            'title' => $course->title,
            'image' => $course->image,
            'instructor' => $course->instructor->first_name . ' ' . $course->instructor->last_name,
            'progress' => $progress,
            'purchase_date' => $this->created_at->toDateString(),
            'average_rating' => $course->reviews()->avg('rating'),
            'total_reviews' => $course->reviews()->count(),
            'total_lessons' => $course->syllabuses?->flatMap->lessons->count() ?? 0,
            'total_hours' => round($course->syllabuses?->flatMap->lessons->sum('duration') / 3600) ?? 0,
        ];
    }
}
