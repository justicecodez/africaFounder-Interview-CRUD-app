<?php

namespace App\Http\Middleware\Guest;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user('sanctum')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'You are already authenticated.',
                ], 403);
            }
        }

        return $next($request);
    }
}
