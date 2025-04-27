<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function createClient(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'device_token' => $data['device_token'] ?? null,
            'verification_code' => $data['verification_code'],
            'verification_expires_at' => $data['verification_expires_at'],
        ]);

        $user->assignRole('client');

        return $user;
    }

    public function createVolunteer(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'device_token' => $data['device_token'] ?? null,
        ]);

        $user->assignRole('volunteer_admin');

        return $user;
    }
}
