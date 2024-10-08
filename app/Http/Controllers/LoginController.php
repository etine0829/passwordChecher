<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    // Handle the login request
    public function login(Request $request)
    {
        // Validate the form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Check if the email exists
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // If the user exists and password is correct, create a session
            Session::put('user_id', $user->id);
            Session::put('email', $user->email);

            // Redirect to the dashboard or intended page with a success message
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        // If login fails, redirect back with an error message
        return back()->withErrors(['email' => 'These credentials do not match our records.'])->onlyInput('email');
    }

    
}
