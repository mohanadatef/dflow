<?php

namespace App\Http\Middleware;

use Closure;

class PermissionMiddelware
{
    public function handle($request, Closure $next, $permission)
    {
        return permissionShow($permission) ? $next($request) : abort(403);
    }
}
