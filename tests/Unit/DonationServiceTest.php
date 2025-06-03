<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\DonationService;
use App\Models\User;
use App\Models\Project;

class DonationServiceTest extends TestCase
{
    public function test_donation_service_creates_stripe_checkout_session()
    {
        $user = User::first(); // use existing user
        $project = Project::first(); // use any existing project
        $this->actingAs($user, 'sanctum');

        $this->assertNotNull($user, 'No user found in database.');
        $this->assertNotNull($project, 'No project found in database.');

        $service = app(DonationService::class);

        $requestData = [
            'amount' => 50,
            'project_id' => $project->id,
            'email' => $user->email,
            'name' => $user->name,
            'user_id' => $user->id,
        ];

        $session = $service->donate($requestData);

        $this->assertNotNull($session);
        $this->assertTrue(isset($session->id) || isset($session['id']));
    }
}
