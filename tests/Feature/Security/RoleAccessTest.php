<?php

namespace Tests\Feature\Security;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Middleware\RoleMiddleware;

class RoleAccessTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

    }

    public function test_client_cannot_access_admin_route()
    {
        $user = User::first();

        // Create the request
        $request = request()->create('/api/admin/complaint/all', 'POST');

        // Attach the user to the request manually
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        // Create the middleware
        $middleware = new RoleMiddleware();

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
