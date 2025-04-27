<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ConfirmRegistrationRequest;
use App\Http\Requests\ConfirmResetRequest;
use App\Http\Requests\CheckEmailRequest;
use App\Http\Requests\RegisterVolunteerReq;
use App\Services\AuthService;
use App\Traits\JsonResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use JsonResponseTrait;

    protected  $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function initiate_registration(RegisterRequest $request): JsonResponse
    {
        try {
             $this->authService->initiate_registration($request);
            return $this->success( 'data initiated successfully and verification code sent to your email');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function confirm_registration(ConfirmRegistrationRequest $request)
    {
        try {
            $data = $this->authService->register($request);
            return $this->success($data, 'Registered successfully');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function resend_code(CheckEmailRequest $request)
    {
        try {
            $data = $this->authService->resend_code($request['email']);
            return $this->success($data, 'Verification code sent to your email');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function reset_password(CheckEmailRequest $request)
    {
        try {
            $data = $this->authService->reset_password($request);
            return $this->success($data, 'the reset code sent to your email');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    public function confirm_reset_password(ConfirmResetRequest $request)
    {
        try {
            $data = $this->authService->confirm_reset_password($request);
            return $this->success($data, 'Password reset successfully');
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
