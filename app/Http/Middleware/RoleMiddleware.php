<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Si no está logueado, que se vaya al login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Si tu user no tiene role, lo tratamos como viewer
        $userRole = auth()->user()->role ?? 'viewer';

        // Si el rol del usuario NO está permitido => 403
        if (!in_array($userRole, $roles, true)) {
            abort(403, 'No tienes permisos para esta acción.');
        }

        return $next($request);
    }
}
