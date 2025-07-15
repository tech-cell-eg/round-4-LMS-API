<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'course_name' => $this->title,
            'course_price' => $this->price,
            'language' => $this->languages,
            'levels' => $this->levels,
            'image' => $this->image ?? 'default-image.jpg',
            'video' => $this->video ?? 'default-video.mp4',
            'description' => $this->description,

        ];
    }
}
