<?php

namespace Tests\Feature\Complaints\Admin;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\ComplaintCategory;

class CategoryManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_category()
    {
        /** @var User $admin */
        $admin = User::factory()->create();

        $this->actingAs($admin, 'sanctum');

        $response = $this->postJson('/api/admin/complaint/category/create', [
            'name' => 'Roads',
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['status' => true]);
    }

    public function test_admin_can_delete_category()
    {
        /** @var User $admin */
        $admin = User::factory()->create();
        $this->actingAs($admin, 'sanctum');

        $category = ComplaintCategory::factory()->create();

        $response = $this->deleteJson("/api/admin/complaint/category/delete/{$category->id}");
        $response->assertStatus(200)
                 ->assertJsonFragment(['status' => true]);
    }
}
