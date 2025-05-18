<?php

namespace App\Http\Middleware;

use App\Traits\JsonResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    use JsonResponseTrait;

    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user() || ! $request->user()->hasRole($role)) {
            return response()->json([
                'status' => false,
                'message' => 'Forbidden, you do not have the required role to access this resource',
                'data' => null,
            ], 403);
        }

        return $next($request);
    }
}
