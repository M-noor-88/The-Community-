<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectRatingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Get all eligible projects
        $projects = DB::table('projects')
            ->where('type', 'حملة رسمية')
            ->where('status', 'منجزة')
            ->get();

        if ($projects->isEmpty()) {
            $this->command->info('No official completed campaigns found. Skipping ratings seeder.');
            return;
        }

        // 2. Predefined rates and comments
        $rateTemplates = [
            ['rating' => 5, 'comment' => 'حملة ممتازة وتستحق الدعم'],
            ['rating' => 4, 'comment' => 'تنفيذ جيد وخدمة راقية'],
            ['rating' => 3, 'comment' => 'حملة رائعة'],
            ['rating' => 2, 'comment' => 'تحتاج إلى بعض التحسين'],
            ['rating' => 1, 'comment' => 'لم تكن بالمستوى المتوقع'],
        ];

        foreach ($projects as $project) {
            $numberOfRatings = rand(4, 5); // 4 or 5 ratings per project
            $usedIndexes = [];

            for ($i = 0; $i < $numberOfRatings; $i++) {
                do {
                    $index = rand(0, count($rateTemplates) - 1);
                } while (in_array($index, $usedIndexes));
                $usedIndexes[] = $index;

                Rating::create([
                    'project_id' => $project->id,
                    'user_id' => rand(2, 7),
                    'rating' => $rateTemplates[$index]['rating'],
                    'comment' => $rateTemplates[$index]['comment'],
                ]);
            }
        }
    }
}
