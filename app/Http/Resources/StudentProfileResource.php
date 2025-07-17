<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentProfileResource extends JsonResource
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
            'description' => $this->description,
            'language' => $this->language,
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            'links' => new SocialLinksResource($this),
        ];
    }
}
