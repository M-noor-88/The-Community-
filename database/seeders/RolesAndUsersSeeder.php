<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\User;
use App\Models\VolunteerField;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

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
        /*
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
        */


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


        // Create 5 real Arabic clients
$arabicClients = [
    ['name' => 'أحمد محمد', 'email' => 'ahmad@example.com'],
    ['name' => 'ليلى خالد', 'email' => 'layla@example.com'],
    ['name' => 'سارة يوسف', 'email' => 'sara@example.com'],
    ['name' => 'محمود علي', 'email' => 'mahmoud@example.com'],
    ['name' => 'فاطمة حسين', 'email' => 'fatima@example.com'],
    ['name' => 'علي عمر', 'email' => 'ali.omar@example.com'],
    ['name' => 'نورا حسن', 'email' => 'noura@example.com'],
    ['name' => 'خالد سمير', 'email' => 'khaled.samir@example.com'],
    ['name' => 'رنا محمود', 'email' => 'rana@example.com'],
    ['name' => 'يوسف جمال', 'email' => 'youssef.jamal@example.com'],
    ['name' => 'هدى ناصر', 'email' => 'huda.nasser@example.com'],
    ['name' => 'سامر خليل', 'email' => 'samer@example.com'],
    ['name' => 'ميساء علاء', 'email' => 'maysaa@example.com']
];

foreach ($arabicClients as $clientData) {
    $user = User::create([
        'name' => $clientData['name'],
        'email' => $clientData['email'],
        'password' => Hash::make('password'), // Default password
        'email_verified_at' => now(),
        'device_token' => Str::random(10),
        'verification_code' => Str::random(10),
        'verification_expires_at' => now()->addMinutes(10),
        'remember_token' => Str::random(10),
    ]);

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
}


        // Create Government Admin
        User::factory()->create([
            'name'=> 'أدمن المحافظة',
            'email' => 'govadmin@example.com',
            'password' => Hash::make('password'),
        ])->assignRole('government_admin');

    }
}
