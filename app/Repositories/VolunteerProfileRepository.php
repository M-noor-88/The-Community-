<?php

namespace App\Repositories;

use App\Models\User;

class VolunteerProfileRepository
{
    public function create(User $user, array $data, int $locationId, int $imageId)
    {
        return $user->volunteerProfile()->create([
            'phone' => $data['phone'],
            'bio' => $data['bio'] ?? null,
            'location_id' => $locationId,
            'image_id' => $imageId,
            'experience_years' => $data['experience_years'] ?? 1,
        ]);
    }
}
