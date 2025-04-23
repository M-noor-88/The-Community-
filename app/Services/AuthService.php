<?php

namespace App\Services;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RegisterVolunteerReq;
use App\Repositories\AuthRepository;
use App\Repositories\ClientProfileRepository;
use App\Repositories\ImageRepository;
use App\Repositories\LocationRepository;
use App\Repositories\UserRepository;
use App\Repositories\VolunteerProfileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthService
{
    //protected AuthRepository $authRepository;

    public function __construct(
        protected UserRepository $userRepo,
        protected LocationRepository $locationRepo,
        protected ImageRepository $imageRepo,
        protected ClientProfileRepository $clientProfileRepo,
        protected VolunteerProfileRepository $volunteerProfileRepo,
        protected AuthRepository $authRepository
    ) {}

    public function register(RegisterRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $validated = $request->validated();

            $user = $this->userRepo->createClient($validated);

            $locationId = $request->filled(['latitude', 'longitude'])
                ? $this->locationRepo->create($validated)
                : 1;

            $image = $this->imageRepo->createPlaceholder();
            if (isset($request['image'])) {
                Log::info("Test");
                $this->imageRepo->storeTempImageAndDispatch($request['image'], $image->id);
            }

            $profile = $this->clientProfileRepo->create($user, $validated, $locationId, $image->id);

            $this->clientProfileRepo->syncSkillsAndFields(
                $profile,
                json_decode($validated['skills'] ?? '[]', true),
                json_decode($validated['volunteer_fields'] ?? '[]', true)
            );

            return [
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken,
            ];
        });
    }

    public function registerVolunteer(RegisterVolunteerReq $request)
    {
        return DB::transaction(function () use ($request) {
            $validated = $request->validated();

            $user = $this->userRepo->createVolunteer($validated);

            $locationId = $request->filled(['latitude', 'longitude'])
                ? $this->locationRepo->create($validated)
                : 1;

            $image = $this->imageRepo->createPlaceholder();
            if (isset($request['image'])) {
                $this->imageRepo->storeTempImageAndDispatch($request['image'], $image->id);
            }

            $this->volunteerProfileRepo->create($user, $validated, $locationId, $image->id);

            return [
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken,
            ];
        });
    }

    /**
     * @throws \Exception
     */
    public function login(Request $request): array
    {
        return $this->authRepository->login($request);
    }

    public function logout(Request $request): void
    {
        $this->authRepository->logout($request);
    }
}
