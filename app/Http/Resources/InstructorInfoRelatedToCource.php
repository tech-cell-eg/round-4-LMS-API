<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorInfoRelatedToCource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            
            'instructor' => [
                'id' => $this->id,
                'name' => $this->first_name . ' ' . $this->last_name,
                'image' => $this->image,
                'headline' => $this->headline,
                'experience' => $this->experience,
            ],

            'courses_count'   => $this->courses->count(),
            'total_students'  => $this->courses->sum(fn($course) => $course->enrollments->count()),
            'total_reviews'   => $this->courses->sum(fn($course) => $course->reviews->count()),

        ];
    }
}
