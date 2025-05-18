<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplaintResource extends JsonResource
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
            'description' => $this->description,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'user' => [
                'userID' => $this->user?->id,
                'created_by' => $this->user?->name,
                'role' => $this->user?->getRoleNames()[0] ?? null,
            ],
            'image_url' => $this->image?->image_url,
            'category' => $this->category?->name,
            'location' => [
                'name' => $this->location?->name,
                'latitude' => $this->location?->latitude,
                'longitude' => $this->location?->longitude,
            ],
            'achievement_images' => $this->achievementImages->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => $image->image_url,
                ];
            }),
            'complaint_images' => $this->complaintImages->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => $image->image_url,
                ];
            }),
        ];
    }
}
