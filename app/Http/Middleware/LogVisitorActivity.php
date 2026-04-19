<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogVisitorActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log the visit if it's a GET request (page view)
        if ($request->isMethod('GET')) {
            try {
                \App\Models\SystemUsage::create([
                    'user_id' => \Illuminate\Support\Facades\Auth::id(),
                    'action' => 'Visited: ' . ($request->path() === '/' ? 'Home' : $request->path()),
                    'device_info' => $request->userAgent()
                ]);
            } catch (\Exception $e) {
                // Fail silently to not interrupt user experience if logging fails
                \Illuminate\Support\Facades\Log::error('Visitor logging failed: ' . $e->getMessage());
            }
        }

        return $next($request);
    }
}
