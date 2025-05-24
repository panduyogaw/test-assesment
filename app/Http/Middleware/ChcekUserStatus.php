<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->status) {
            return response()->json(['error' => 'User is inactive'], 403);
        }
        return $next($request);
    }
}
