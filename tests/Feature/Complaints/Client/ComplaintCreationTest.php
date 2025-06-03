<?php

namespace Tests\Feature\Complaints\Client;

use Tests\TestCase;
use App\Models\User;
use App\Models\ComplaintCategory;
use App\Models\Location;
use App\Models\Region;

class ComplaintCreationTest extends TestCase
{

    public function test_can_create_complaint()
    {
        $user = User::first();
        $location = Location::first();
        $category = ComplaintCategory::first();
        $region =Region::first();

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('api/client/complaint/create', [
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
            'area' => $region->name,
            'complaintImages' => [
                '' => [
                    'URL_ADDRESS.com/image1' => [
                        'URL_ADDRESS.com/image1.jpg',
                    ],
                ],
            ],
            'complaint_category_id' => $category->id,
            'title' => 'Noise Pollution',
            'description' => 'Loud noise every night',
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['status' => true]);
    }

    public function test_guest_cannot_create_complaint()
    {
        $response = $this->postJson('/api/client/complaint/create', []);
        $response->assertStatus(401);
    }
}
