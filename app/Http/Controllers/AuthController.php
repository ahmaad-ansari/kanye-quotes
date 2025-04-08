<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Session::has('is_authenticated')) {
            return redirect()->route('quote.index');
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if ($request->password === config('auth.app_password')) {
            Session::put('is_authenticated', true);
            return redirect()->route('quote.index');
        }

        return redirect('/login')->withErrors(['password' => 'Invalid password.']);
    }

    public function logout()
    {
        Session::forget('is_authenticated');
        return redirect()->route('login');
    }
}
