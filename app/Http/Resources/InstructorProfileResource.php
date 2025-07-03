<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'username' => $this->username,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'headline' => $this->headline,
            'image' => $this->image,
            'socials' => new SocialLInksResource($this->whenLoaded('social')),

            'total_reviews' => $this->reviews()->count(),
            'average_rating' => $this->reviews()->avg('rating'),
            'total_students' => $this->courses->flatMap->enrollments->pluck('user_id')->unique()->count(),

            'about' => $this->about,
            'areas_of_expertise' => $this->areas_of_expertise,
            'experience' => $this->experience,

            'courses' => CourseResource::collection($this->whenLoaded('courses')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
        ];
    }
}
