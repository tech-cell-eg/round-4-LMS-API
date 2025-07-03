<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'reviewed_type' => class_basename($this->reviewable_type),
            'reviewed_id' => $this->reviewable_id,
            'user' => [
                'username' => $this->user->username,
                'image' => $this->user->image,
                'name' => $this->user->first_name . ' ' . $this->user->last_name,
            ],
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
