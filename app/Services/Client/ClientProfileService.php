<?php

namespace App\Services\Client;

use App\Models\ClientProfile;
use App\Repositories\ClientProfileRepository;
use Illuminate\Support\Facades\DB;

class ClientProfileService
{
    public function __construct(protected ClientProfileRepository $clientProfileRepo) {}

    public function updateProfile(ClientProfile $profile, array $data, array $skills = [], array $fields = []): ClientProfile
    {
        $updated = $this->clientProfileRepo->update($profile, $data);

        $this->clientProfileRepo->syncSkillsAndFields($updated, $skills, $fields);

        return $updated;
    }

    public function getProfileForUserFormatted($userId): array
    {
        $profile = $this->clientProfileRepo->getByUserId($userId);
        $user = DB::table('users')->select('name', 'email')->where('id', $userId)->first();

        return [
            'id' => $profile->id,
            'user_id' => $profile->user_id,
            'name' => $user->name,
            'email' => $user->email,
            'location' => [
                'name' => $profile->location->name ?? null,
                'latitude' => $profile->location->latitude ?? null,
                'longitude' => $profile->location->longitude ?? null,
            ],
            'image_url' => $profile->image->image_url ?? null,
            'bio' => $profile->bio,
            'phone' => $profile->phone,
            'age' => $profile->age,
            'gender' => $profile->gender,
            'skills' => $profile->skills->pluck('name'),
            'fields' => $profile->fields->pluck('name'),
            'created_at' => $profile->created_at,

        ];
    }

    public function getProfileForUser($userId): ?ClientProfile
    {
        return $this->clientProfileRepo->getByUserId($userId);
    }

    public function deleteProfile(ClientProfile $profile): void
    {
        $this->clientProfileRepo->delete($profile);
    }
}
