<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'headline' => $this->headline,
            'rating' => round($this->reviews_avg_rating, 1), // أو كما تريد
            'image' => $this->image,
             'students_count' => $this->courses->sum(function ($course) {
            return $course->enrollments->count();
        }),

        ];
    }
}
