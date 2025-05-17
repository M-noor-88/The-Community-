<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VoteOnProjectTest extends TestCase
{


    public function test_user_can_vote_on_initiative_project()
    {
        $user = User::factory()->create();

        $project = Project::factory()->create([
            'type' => 'مبادرة',
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson("/api/client/project/vote/{$project->id}", [
            'value' => 1,
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'تم تسجيل صوتك!']);

        $this->assertDatabaseHas('votes', [
            'user_id' => $user->id,
            'project_id' => $project->id,
            'value' => 1,
        ]);

        $this->assertDatabaseHas('vote_project_totals', [
            'project_id' => $project->id,
            'likes' => 1,
            'dislikes' => 0,
        ]);
    }

    public function test_user_cannot_vote_twice_on_same_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['type' => 'مبادرة']);

        // First vote
        $this->actingAs($user, 'sanctum')->postJson("/api/client/project/vote/{$project->id}", [
            'value' => 1,
        ]);

        // Second vote
        $response = $this->actingAs($user, 'sanctum')->postJson("/api/client/project/vote/{$project->id}", [
            'value' => -1,
        ]);

        $response->assertStatus(500); // Expected error
        $response->assertJsonFragment([
            'message' => 'لقد قمت بالتصويت بالفعل',
        ]);
    }

    public function test_user_cannot_vote_on_non_initiative_project()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'type' => 'حملة رسمية', // Not "مبادرة"
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson("/api/client/project/vote/{$project->id}", [
            'value' => 1,
        ]);

        $response->assertStatus(500);
        $response->assertJsonFragment([
            'message' => 'التصويت متاح فقط في المبادرات',
        ]);
    }

    public function test_vote_fails_if_project_does_not_exist()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson("/api/client/project/vote/999", [
            'value' => 1,
        ]);

        $response->assertStatus(500);
        $response->assertJsonFragment([
            'message' => 'المشروع غير موجود',
        ]);
    }

    public function test_guest_cannot_vote()
    {
        $project = Project::factory()->create();

        $response = $this->postJson("/api/client/project/vote/{$project->id}", [
            'value' => 1,
        ]);

        $response->assertStatus(401);
    }

    public function test_validation_error_when_value_missing_or_invalid()
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['type' => 'مبادرة']);

        $response = $this->actingAs($user, 'sanctum')->postJson("/api/client/project/vote/{$project->id}", [
            'value' => 5, // Invalid
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['value']);
    }
}
