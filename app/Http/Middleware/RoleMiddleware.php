<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\JsonResponseTrait;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    use JsonResponseTrait;

    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user() || !$request->user()->hasRole($role)) {
            return response()->json([
                'status' => false,
                'message' => 'Forbidden, you do not have the required role to access this resource',
                'data' => null,
            ], 403);
        }

        return $next($request);
    }
}
