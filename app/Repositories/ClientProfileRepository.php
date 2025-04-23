<?php

namespace App\Repositories;

use App\Models\ClientProfile;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ClientProfileRepository
{
    public function create(User $user, array $data, int $locationId, int $imageId)
    {
        return $user->clientProfile()->create([
            'phone' => $data['phone'],
            'age' => $data['age'],
            'gender' => $data['gender'],
            'bio' => $data['bio'] ?? null,
            'location_id' => $locationId,
            'image_id' => $imageId,
        ]);
    }

    public function syncSkillsAndFields($profile, array $skills = [], array $fields = []): void
    {
        if (!empty($skills)) {
            $profile->skills()->sync($skills);
            $profile->save();
        }

        if (!empty($fields)) {
            $profile->fields()->sync($fields);
            $profile->save();
        }
    }


    public function update(ClientProfile $profile, array $data): ClientProfile
    {
        $profile->update($data);
        return $profile;
    }

    public function getByUserId($userId): ?ClientProfile
    {
        return ClientProfile::with(['skills', 'fields', 'location', 'image'])->where('user_id', $userId)->first();
    }

    public function delete(ClientProfile $profile): void
    {
        $profile->delete();
    }
}
