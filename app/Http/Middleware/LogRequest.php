<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Log;
use App\Models\ActivityLog;
use Ramsey\Uuid\Uuid;

class LogRequest
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $user = $request->user();
        if ($user) {
            ActivityLog::create([
                'id' => Uuid::uuid4()->toString(),
                'user_id' => $user->id,
                'action' => $request->method() . ' ' . $request->path(),
                'description' => 'Request to ' . $request->fullUrl(),
                'logged_at' => now(),
            ]);
            Log::channel('api')->info('Request', [
                'user_id' => $user->id,
                'method' => $request->method(),
                'url' => $request->fullUrl(),
            ]);
        }

        return $response;
    }
}
