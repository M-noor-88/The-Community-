<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('projects')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'image_id' => 1,
                'category_id' => 1,
                'location_id' => 1,
                'number_of_participant' => 10,
                'title' => 'Clean Water Initiative',
                'description' => 'Providing access to clean water in rural areas.',
                'Execution_date' => now()->addDays(30),
                'created_by' => 1,
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'image_id' => 2,
                'category_id' => 2,
                'location_id' => 2,
                'number_of_participant' => 5,
                'title' => 'Education Project',
                'description' => 'Promoting education in underprivileged areas.',
                'Execution_date' => now()->addDays(15),
                'created_by' => 2,
            ],
            // Add more projects as needed

        ]
        );

    }
}
