<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Complaint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use App\Models\ComplaintCategory;
use App\Models\Location;

class ComplaintStatusUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_complaint_status()
    {
        Role::firstOrCreate(['name' => 'government_admin']);
        /** @var User $admin */
        $admin = User::factory()->create();
        $admin->assignRole('government_admin');

        Role::firstOrCreate(['name' => 'client']);
        /** @var User $client */
        $client = User::factory()->create();
        $client->assignRole('client');
        $location = Location::factory()->create();
        $category = ComplaintCategory::factory()->create();

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
