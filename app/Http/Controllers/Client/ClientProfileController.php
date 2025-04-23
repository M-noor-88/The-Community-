<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientUpdateRequest;
use App\Services\Client\ClientProfileService;
use App\Traits\JsonResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ClientProfileController extends Controller
{
    use JsonResponseTrait;

    public function __construct(protected ClientProfileService $clientProfileService) {}

    public function show(int $id = 1): JsonResponse
    {
        try {
            $userId = Auth::id() ?? $id;
            $profile = $this->clientProfileService->getProfileForUserFormatted($userId);

            if (! $profile) {
                return $this->error('Profile not found', 404);
            }

            return $this->success($profile, 200);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function update(ClientUpdateRequest $request): JsonResponse
    {
        try {
            $userId = Auth::id();
            $profile = $this->clientProfileService->getProfileForUser($userId);

            if (! $profile) {
                return $this->error('Profile not found', 404);
            }

            if ($request->filled(['latitude', 'longitude'])) {
                $locationData = [
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'name' => $request->area,
                ];
                $profile->location()->update($locationData);
            }
            $data = $request->only(['phone', 'age', 'gender', 'bio']);
            $skills = json_decode($request->skills ?? '[]', true);
            $fields = json_decode($request->volunteer_fields ?? '[]', true);
            $updated = $this->clientProfileService->updateProfile($profile, $data, $skills, $fields);

            return $this->success([], 'Profile updated , Go Checkout show my profile API and set the same token');
        } catch (Exception $e) {
            return $this->error(['Failed to update profile', 'details' => $e->getMessage()]);
        }
    }
}
