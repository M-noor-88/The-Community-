<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Complaint;
use Spatie\Permission\Models\Role;
use App\Models\ComplaintCategory;
use App\Models\Location;

class ComplaintStatusUpdateTest extends TestCase
{

    public function test_admin_can_update_complaint_status()
    {
        $admin = User::find(13);
        $admin->assignRole('government_admin');

        $client = User::first();
        $client->assignRole('client');

        $location = Location::first();
        $category = ComplaintCategory::first();

        $complaint = Complaint::factory()->create([
            'user_id' => $client->id,
            'location_id' => $location->id,
            'complaint_category_id' => $category->id,
            'title' => 'Water Leakage',
            'description' => 'Leak in the kitchen pipe.',
            'status' => 'انتظار',
        ]);

        $this->actingAs($admin, 'sanctum');

        $response = $this->postJson("/api/admin/complaint/{$complaint->id}/updateStatus", [
            'status' => 'منجزة',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['status' => true]);
    }
}
