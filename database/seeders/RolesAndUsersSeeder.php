<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\User;
use App\Models\VolunteerField;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $roles = ['client', 'volunteer_admin', 'government_admin'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $skills = Skill::all();
        $fields = VolunteerField::all();

        // Create Clients
        User::factory(5)->create()->each(function ($user) use ($skills, $fields) {
            $user->assignRole('client');

            // Create profile
            $profile = $user->clientProfile()->create([
                'phone' => fake()->phoneNumber(),
                'bio' => fake()->text(),
                'location_id' => 1,
                'gender' => fake()->randomElement(['male', 'female']),
                'age'=> 22,
                'image_id'=> 1
            ]);

            // Attach random skills & fields
            $profile->skills()->attach($skills->random(rand(1, 3))->pluck('id')->toArray());
            $profile->fields()->attach($fields->random(rand(1, 2))->pluck('id')->toArray());
        });

        // Create Volunteer Admins
        User::factory(2)->create()->each(function ($user) {
            $user->assignRole('volunteer_admin');

            // Create profile with fake image path
            $user->volunteerProfile()->create([
                'phone' => fake()->phoneNumber(),
                'location_id' => 1,
                'bio' => fake()->text(),
                'image_id' => 1,
                'experience_years'=> 3
            ]);
        });

        // Create Government Admin
        User::factory()->create([
            'email' => 'govadmin@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('government_admin');

    }
}
