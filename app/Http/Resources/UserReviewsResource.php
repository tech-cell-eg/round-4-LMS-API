<?php

namespace App\Http\Resources;

use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserReviewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $reviewable = $this->reviewable;

        if ($reviewable instanceof Course) {
            $label = 'course_title';
            $value = $reviewable->title ?? 'Unknown Course';
        } elseif ($reviewable instanceof Instructor) {
            $label = 'instructor_name';
            $value = trim(($reviewable->first_name ?? '') . ' ' . ($reviewable->last_name ?? ''));
        }

        return [
            'id' => $this->id,
            $label => $value,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'date' => $this->created_at->toDateString(),
        ];
    }
}
