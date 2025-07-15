<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class syllabusResourcesResource extends JsonResource
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
            'title' => $this->title,
            'type' => $this->type,
            'description' => $this->description,
            'file_path' => $this->file_path ? asset('storage/' . $this->file_path) : null,
            'thumbnail_path' => $this->thumbnail_path ? asset('storage/' . $this->thumbnail_path) : null,
        ];
    }
}
