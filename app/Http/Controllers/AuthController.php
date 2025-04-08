<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Show the login form or redirect to the quote page if already authenticated
    public function showLoginForm()
    {
        if (Session::has('is_authenticated')) {
            return redirect()->route('quote.index');  // Redirect to quote page if authenticated
        }
        
        return view('auth.login');  // Show the login form if not authenticated
    }

    // Handle login logic, validate password and store session data if valid
    public function login(Request $request)
    {
        $request->validate([  // Validate password input
            'password' => 'required|string',
        ]);

        // Check if the password matches the configured app password
        if ($request->password === config('auth.app_password')) {
            Session::put('is_authenticated', true);  // Store authentication in session
            return redirect()->route('quote.index');  // Redirect to quote page after successful login
        }

        // Redirect back with an error message if the password is invalid
        return redirect('/login')->withErrors(['password' => 'Invalid password.']);
    }

    // Log out the user by clearing session data and redirect to login page
    public function logout()
    {
        Session::forget('is_authenticated');  // Clear session data
        return redirect()->route('login');  // Redirect to login page after logout
    }
}
