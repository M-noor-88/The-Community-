<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Google\Service\Directory\Roles;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SkillSeeder::class,
            VolunteerFieldSeeder::class,
            LocationAndImageSeeder::class,
            RolesAndUsersSeeder::class,
            ComplaintsCategorySeeder::class,
            ProjectsCategorySeeder::class,
            ComplaintSeeder::class,
            ComplaintImageSeeder::class,
            KeywordSeeder::class,
            ProjectSeeder::class,
            CampaignDonationsSeeder::class,

        ]);
    }
}
