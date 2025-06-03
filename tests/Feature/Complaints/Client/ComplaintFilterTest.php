<?php

namespace Tests\Feature\Complaints\Client;

use Tests\TestCase;
use App\Models\User;
use App\Models\Location;
use App\Models\Image;

class ComplaintFilterTest extends TestCase
{
    public function test_can_filter_own_complaints()
    {
        $user = User::first();
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/client/complaint/all', [
            'status' => 'انتظار',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['status', 'message', 'data']);
    }

    public function test_nearby_complaints()
    {
        $user = User::first();
        $image = Image::first();
        $location = Location::first();

        $user->clientProfile()->create([
            'user_id' => $user->id,
            'image_id' => $image->id,
            'bio' => 'Bio',
            'phone' => '1234567890',
            'age' => 25,
            'gender' => 'Male',
            'location_id' => $location->id,
        ]);

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/client/complaint/all', [
            'nearby' => '1',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['status', 'message', 'data']);
    }
}
