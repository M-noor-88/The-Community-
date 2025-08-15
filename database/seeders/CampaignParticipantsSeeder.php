<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CampaignParticipant;
use App\Models\User;
use App\Models\Project;

class CampaignParticipantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 campaign participants
        for ($i = 0; $i < 10; $i++) {
            CampaignParticipant::create([
                'user_id' => rand(1, 7),
                'project_id' => rand(1, 10),
                'status' => fake()->randomElement(['انتظار', 'تمت الموافقة' , 'تم الرفض' ]),
                'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
                'updated_at' => fake()->dateTimeBetween('-1 year', 'now'),
            ]);
        }
    }
}
