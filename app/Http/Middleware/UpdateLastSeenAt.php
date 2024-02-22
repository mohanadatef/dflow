<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UpdateLastSeenAt
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            user()->update(['last_seen_at' => now()]);
        }
        return $next($request);
    }
}
