<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle($request, Closure $next, $permission)
    {
        if(user())
        {
            if(($request->url() == route('user.edit', \user()->id)) || ($request->url() == route('user.update',
                        \user()->id)))
            {
                return $next($request);
            }elseif(\user()->suspended)
            {
                return redirect(route('user.edit', \user()->id));
            }
          return permissionShow($permission) ? $next($request) : abort(403);
        }
        Auth::logout();
        return redirect('/login');
    }
}
