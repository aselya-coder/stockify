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

        // Split roles by pipe character into an array
        $allowedRoles = explode('|', $roles);

        // 🔧 PERBAIKAN: Gunakan metode hasAnyRole() dari package spatie
        if (!$request->user()->hasAnyRole($allowedRoles)) {
            // Pesan error dibuat mirip dengan aslinya
            abort(403, '403 UNAUTHORIZED. REQUIRED ROLE: ' . strtoupper(implode(' OR ', $allowedRoles)));
        }

        return $next($request);
    }
}