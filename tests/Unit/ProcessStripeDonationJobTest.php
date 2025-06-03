<?php

namespace Tests\Unit\Jobs;

use Tests\TestCase;
use App\Jobs\ProcessStripeDonationJob;
use App\Models\User;
use App\Models\Project;
use App\Models\CampaignDonation;
use App\Models\CampaignDonationSummary;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProcessStripeDonationJobTest extends TestCase
{
    public function test_it_processes_successful_donation()
    {
        $user = User::first();
        $project = Project::first();

        $this->assertNotNull($user, 'User not found');
        $this->assertNotNull($project, 'Project not found');

        // Mock a Stripe session object
        $mockSession = new \stdClass();
        $mockSession->metadata = (object)[
            'user_id' => $user->id,
            'campaign_id' => $project->id,
        ];
        $mockSession->payment_intent = 'pi_test_' . uniqid();
        $mockSession->amount_total = 2500;

        // Run the job
        $job = new ProcessStripeDonationJob($mockSession, 'success');
        $job->handle();

        // Assert that donation was created
        $this->assertDatabaseHas('campaign_donations', [
            'user_id' => $user->id,
            'project_id' => $project->id,
            'amount' => 25.00,
            'status' => 'مدفوع',
            'payment_intent_id' => $mockSession->payment_intent,
        ]);

        // Assert the summary was updated
        $summary = CampaignDonationSummary::where('project_id', $project->id)->first();
        $this->assertNotNull($summary);
        $this->assertGreaterThanOrEqual(25, $summary->total_donated);
        $this->assertGreaterThanOrEqual(1, $summary->total_donors);
    }
}
