<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Project;

class CampaignDonationSummarySeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();



        foreach ($projects as $project) {
            if ($project->status == 'نشطة') {

                $total_donated = rand(20,1000);// You can calculate and update this later
                DB::table('campaign_donation_summaries')->insert([
                    'project_id' => $project->id,
                    'total_donated' => $total_donated, // You can calculate and update this later
                    'total_donors' => rand(2,20),  // Will be updated from campaign_donations
                    'required_amount' => rand($total_donated, $total_donated+ 1000), // Fake target amount
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            else {
                DB::table('campaign_donation_summaries')->insert([
                    'project_id' => $project->id,
                    'total_donated' => 0, // You can calculate and update this later
                    'total_donors' => 0,  // Will be updated from campaign_donations
                    'required_amount' => rand(1000, 10000), // Fake target amount
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
