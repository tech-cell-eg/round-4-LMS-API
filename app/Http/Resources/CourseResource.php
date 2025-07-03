<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

          return [
        'title' => $this->title,
        'instructor_name' => $this->instructor?->first_name . ' ' . $this->instructor?->last_name,
        'reviews_count' => $this->reviews->count(),
        'duration_hours' => $this->syllabuses->sum('duration'),
        'lectures_count' => $this->syllabuses->count(),
        'level' => $this->levels,
        'price' => $this->price,
    ];
    }
}
