<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\CampaignDonationSummary;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use App\Jobs\ProcessStripeDonationJob;
use Stripe\Webhook;

class DonationFlowTest extends TestCase
{
    use WithFaker;

    public function test_user_can_access_donation_url()
    {
        $user = User::first(); // Use existing user
        $project = Project::first(); // Use existing project

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('api/Donation/donate', [
            'project_id' => $project->id,
            'amount' => 10
        ]);


        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'data'
                 ]);
    }

    public function test_donation_amount_must_be_valid()
    {
        $user = User::first();
        $project = Project::first();

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('api/Donation/donate', [
            'project_id' => $project->id,
            'amount' => 0 // invalid amount
        ]);

        $response->assertStatus(422)
        ->assertJsonValidationErrors(['amount']);
    }

}
