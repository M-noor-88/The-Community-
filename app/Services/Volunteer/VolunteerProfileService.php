<?php

namespace App\Services\Volunteer;

use App\Models\User;
use App\Models\VolunteerProfile;
use App\Repositories\ImageRepository;
use App\Repositories\LocationRepository;
use App\Repositories\VolunteerProfileRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VolunteerProfileService
{
    public function __construct(
        protected VolunteerProfileRepository $volunteerProfileRepo,
        protected LocationRepository $locationRepo,
        protected ImageRepository $imageRepo,
    ) {}

    /**
     * @throws Exception
     */
    public function updateVolunteer($userID, array $data): VolunteerProfile
    {
        if (! Auth::user()->hasRole('government_admin')) {
            throw new Exception('ليس لديك الصلاحية ');
        }
        $user = User::with('volunteerProfile')->findOrFail($userID);

        return DB::transaction(function () use ($user, $data) {
            $locationId = $user->volunteerProfile->location->id;
            if (isset($data['latitude'], $data['longitude'])) {
                $locationId = $this->locationRepo->update($data, $locationId);
            }

            $imageId = $user->volunteerProfile?->image_id;
            if (isset($data['image'])) {
                $image = $this->imageRepo->createPlaceholder();
                $this->imageRepo->storeTempImageAndDispatch($data['image'], $image->id);
                $imageId = $image->id;
            }

            return $this->volunteerProfileRepo->update($user, $data, $locationId, $imageId);
        });
    }

    public function deleteVolunteer($userID): bool
    {
        $user = User::where('id', $userID)->first();

        return DB::transaction(fn () => $this->volunteerProfileRepo->delete($user));
    }

    public function showProfile(): array
    {
        $userID = Auth::id();
        $profile = $this->volunteerProfileRepo->get($userID);

        return [
            'name' => $profile->user?->name,
            'bio' => $profile->bio,
            'experience_years' => $profile->experience_years,
            'phone' => $profile->phone,
            'location' => [
                'longitude' => $profile->location?->longitude,
                'latitude' => $profile->location?->latitude,
                'area' => $profile->location?->name,
            ],
            'image' => $profile->image->image_url ?? 'null',
        ];

    }
}
