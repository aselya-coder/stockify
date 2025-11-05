<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        // Check if user is authenticated
        if (!$request->user()) {
            abort(401, 'Unauthenticated.');
        }

        // Split roles by pipe character
        $allowedRoles = explode('|', $roles);

        // Check if user has the required role
        if (!in_array($request->user()->role, $allowedRoles)) {
            abort(403, 'Unauthorized. Required role: ' . implode(' or ', $allowedRoles));
        }

        return $next($request);
    }
}