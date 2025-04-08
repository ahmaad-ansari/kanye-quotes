<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenAuth
{
    /**
     * Handle an incoming request to authenticate with API token.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the token from the Authorization header
        $token = $request->bearerToken();

        // Check if token is missing or incorrect
        if (!$token || $token !== config('auth.api_token')) {
            return response()->json(['error' => 'Unauthorized'], 401);  // Unauthorized response
        }

        return $next($request);  // Proceed with the request if token is valid
    }
}
