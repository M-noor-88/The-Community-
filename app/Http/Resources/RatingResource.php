<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ratingID' => $this->id,
            'rating' => $this->rating,
            'comment' => $this->comment ?? 'لم يعلق',
            'user' => $this->user->name,
            'date' => $this->created_at->format('Y-m-d'),
        ];
    }
}
