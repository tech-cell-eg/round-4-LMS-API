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
            'slug' => $this->slug,
            'title' => $this->title,
            'image' => $this->image,
            'instructor' => $this->instructor->first_name . ' ' . $this->instructor->last_name,
            'price' => $this->price,
            'level' => $this->level,
            'average_rating' => $this->reviews()->avg('rating'),
            'total_reviews' => $this->reviews()->count(),
            'total_lessons' => $this->syllabuses?->flatMap->lessons->count() ?? 0,
            'total_hours' => round($this->syllabuses?->flatMap->lessons->sum('duration') / 3600) ?? 0,
        ];
    }
}
