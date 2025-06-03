<?php

namespace App\Http\Controllers\Volunteer;

use App\Http\Controllers\Controller;
use App\Services\Volunteer\VolunteerProfileService;
use App\Traits\JsonResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VolunteerProfileController extends Controller
{
    use JsonResponseTrait;

    public function __construct(protected VolunteerProfileService $volunteerService) {}

    public function update(Request $request, $userID): JsonResponse
    {
        try {
            $validated = $request->validate([
                'bio' => 'nullable|string',
                'phone' => 'nullable|string',
                'experience_years' => 'nullable|integer|min:0',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'area' => 'nullable|string',
            ]);

            $profile = $this->volunteerService->updateVolunteer($userID, $validated);

            return $this->success($profile, 'Profile updated');
        } catch (ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (Exception $e) {
            return $this->error('Failed to update profile', 500, ['exception' => $e->getMessage()]);
        }
    }

    // For Admin
    public function destroy($userID): JsonResponse
    {
        try {
            $this->volunteerService->deleteVolunteer($userID);

            return $this->success([], 'Volunteer profile deleted successfully');
        } catch (Exception $e) {
            return $this->error('Failed to delete profile', 500, ['exception' => $e->getMessage()]);
        }
    }

    public function showProfile(): JsonResponse
    {
        try {
            $data = $this->volunteerService->showProfile();

            return $this->success($data, 'Success');
        } catch (Exception $e) {
            return $this->error('Failed to get Profile'.$e->getMessage());
        }
    }


    // For Admin

    public function getAllVolunteersProfiles(): JsonResponse
    {
        try {
            $data = $this->volunteerService->getAllProfiles();

            return $this->success($data , 'success');
        } catch(Exception $e)
        {
            return $this->error('Failed to get '.$e->getMessage());
        }
    }
 }
