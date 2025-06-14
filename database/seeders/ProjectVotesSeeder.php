<?php

namespace Database\Seeders;

use App\Models\Vote;
use App\Models\VoteProjectTotal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectVotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all initiative projects under voting stage
        $projects = DB::table('projects')
            ->where('type', 'مبادرة')
            ->where('status', 'تصويت')
            ->get();

        if ($projects->isEmpty()) {
            $this->command->info('No initiative projects in voting status.');
            return;
        }

        $users = range(1, 7); // 7 users

        foreach ($projects as $project) {
            $votedUsers = collect($users)->shuffle()->take(rand(4, 7)); // 4-7 random users

            $likes = 0;
            $dislikes = 0;

            foreach ($votedUsers as $userId) {
                $value = rand(0, 1) ? 1 : -1;

                Vote::create([
                    'user_id' => $userId,
                    'project_id' => $project->id,
                    'value' => $value
                ]);

                if ($value === 1) {
                    $likes++;
                } else {
                    $dislikes++;
                }
            }

            // Update or create the vote total summary
            VoteProjectTotal::updateOrCreate(
                ['project_id' => $project->id],
                ['likes' => $likes, 'dislikes' => $dislikes]
            );
        }
    }
}
