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
