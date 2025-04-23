<?php

namespace App\Repositories;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\RegisterVolunteerReq;
use App\Jobs\UploadImageJob;
use App\Models\Image;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class AuthRepository
{
    /**
     * @throws Exception
     */
    public function login($request): array
    {
        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {
            throw new Exception('Invalid credentials');
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout($request): void
    {
        $request->user()->tokens()->delete();
    }

}
