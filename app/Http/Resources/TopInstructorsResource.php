<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopInstructorsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'email'       => $this->email,
            'average_rating' => round($this->reviews_avg_rating, 2), // من withAvg
            'total_students' => $this->courses->sum(fn($course) => $course->enrollments->count()),
        ];
    }
}
