<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\VolunteerProfile;

class VolunteerProfileRepository
{
    public function get($userID)
    {
        return VolunteerProfile::where('user_id', $userID)
            ->with(['image', 'location', 'user'])
            ->first();
    }

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

    public function update(User $user, array $data, ?int $locationId = null, ?int $imageId = null): VolunteerProfile
    {
        $profile = $user->volunteerProfile;

        $profile->update(array_filter([
            'bio' => $data['bio'] ?? null,
            'phone' => $data['phone'] ?? null,
            'experience_years' => $data['experience_years'] ?? null,
            'location_id' => $locationId,
            'image_id' => $imageId,
        ]));

        return $profile;
    }

    public function delete(User $user): bool
    {
        return $user->volunteerProfile?->delete();
    }
}
