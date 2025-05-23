<?php

namespace Tests\Feature\Complaints\Client;

use Tests\TestCase;
use App\Models\User;
use App\Models\ComplaintCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Location;
use App\Models\Region;

class ComplaintCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_complaint()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $location = Location::factory()->create();
        $category = ComplaintCategory::factory()->create();
        $region =Region::factory()->create();

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('api/client/complaint/create', [
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
            'region' => $region->name,
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

        //dd($response);



        $response->assertStatus(201)
                 ->assertJsonFragment(['status' => true]);
    }

    public function test_guest_cannot_create_complaint()
    {
        $response = $this->postJson('/api/client/complaint/create', []);
        $response->assertStatus(401);
    }
}
