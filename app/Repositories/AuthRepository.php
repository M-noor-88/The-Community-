<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;
use Google\Service\Docs\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    protected const REGISTRATION_CACHE_PREFIX = 'registration_';
    protected const REGISTRATION_CACHE_MINUTES = 100; // Can easily change it in the future


    public function initiateRegistration(array $data): void
    {
        $cacheKey = self::REGISTRATION_CACHE_PREFIX . $data['email'];

        Cache::put($cacheKey,$data
        , now()->addMinutes(self::REGISTRATION_CACHE_MINUTES));
    }


    public function getUserData($email)
    {
        $cacheKey = self::REGISTRATION_CACHE_PREFIX . $email;
        $data = Cache::get($cacheKey);
        return $data;
    }

    public function deleteUserData($email)
    {
        $cacheKey = self::REGISTRATION_CACHE_PREFIX . $email;
        Cache::forget($cacheKey);
        return ;
    }

    public function cacheResetCode(array $request)
    {
        $cacheKey = 'reset_code_'.$request['email'];
        Cache::put($cacheKey, $request,now()->addMinutes(self::REGISTRATION_CACHE_MINUTES));
        return ;
    }

    public function getResetCode($email)
    {
        $cacheKey ='reset_code_'.$email;
        $data = Cache::get($cacheKey);
        return $data;
    }

    public function deleteResetCode($email)
    {
        $cacheKey ='reset_code_'.$email;
        Cache::forget($cacheKey);
    }

    public function updatePassword(array $request)
    {
        $user = User::where('email', $request['email'])->first();
        if (!$user) {
            throw new Exception('User not found with email: ' . $request['email']);
        }
        $user->password = Hash::make($request['new_password']);
        $user->save();
        return $user;
    }

    public function login($request): array
    {
        $credentials = $request->only('email', 'password');
        if (! Auth::attempt($credentials)) {
            throw new Exception('Invalid credentials');
        }
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        $role=$user->getRoleNames()->first();


        return [
            'user' => $user,
            'role' => $role,
            'token' => $token,
        ];
    }

    /**
     * Logout user by deleting all tokens.
     */
    public function logout($request): void
    {
        $request->user()->tokens()->delete();
    }
}
