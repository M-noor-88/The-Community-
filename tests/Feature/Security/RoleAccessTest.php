<?php

namespace Tests\Feature\Security;

use App\Http\Middleware\RoleMiddleware;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create roles before running tests
        Role::create(['name' => 'government_admin']);
        Role::create(['name' => 'client']);
    }

    public function test_client_cannot_access_admin_route()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->assignRole('client');

        // Acting as the user (optional here since you're mocking request manually)
        $this->actingAs($user, 'sanctum');

        // Create the request
        $request = request()->create('/api/admin/complaint/all', 'POST');

        // Attach the user to the request manually
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        // Create the middleware
        $middleware = new \App\Http\Middleware\RoleMiddleware();

        // Pass the request through the middleware
        $response = $middleware->handle(
            $request,
            function () {
                return response()->json(['status' => true, 'message' => 'Access granted', 'code' => 200], 200);
            },
            'government_admin' // Required role
        );

        // Assert the correct status
        $this->assertEquals(403, $response->getStatusCode());
    }


    public function test_guest_is_unauthorized()
    {
        $response = $this->postJson('/api/client/complaint/all');
        $response->assertStatus(401); // unauthorized
    }
}
