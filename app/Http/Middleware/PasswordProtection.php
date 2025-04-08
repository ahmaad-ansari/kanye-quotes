<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class PasswordProtection
{
    /**
     * Handle an incoming request to check for authentication.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated by session
        if (!Session::has('is_authenticated')) {
            return redirect()->route('login');  // Redirect to login if not authenticated
        }
        
        return $next($request);  // Proceed with the request if authenticated
    }
}
