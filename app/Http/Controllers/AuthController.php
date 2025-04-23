<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RegisterVolunteerReq;
use App\Services\AuthService;
use App\Traits\JsonResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use JsonResponseTrait;

    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $data = $this->authService->register($request);

            return $this->success($data, 'Registered successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    // Register Volunteer
    public function registerVolunteer(RegisterVolunteerReq $request): JsonResponse
    {
        try {
            $data = $this->authService->registerVolunteer($request);

            return $this->success($data, 'Volunteer Registered successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $data = $this->authService->login($request);

            return $this->success($data, 'Logged in successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 401);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout($request);

            return $this->success([], 'Logged out successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
