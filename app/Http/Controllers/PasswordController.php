<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function index()
    {
        return view('passwordChecker');
    }

    public function checkPassword(Request $request)
    {
        // Validate the email but do not impose the minimum length on the password at this stage
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ], [
            'email.unique' => 'The email is already taken.',
            'email.required' => 'Email is required.',
            'password.required' => 'Password is required.',
        ]);

        $password = $request->password;
        $email = $request->email;

        $errors = [];

        // Check if the password is at least 8 characters long
        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters long.';
        }

        // Perform other custom password validation regardless of length
        if (!preg_match('/^@/', $password)) {
            $errors[] = 'Password must start with the "@" character.';
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter (A-Z).';
        }
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password must contain at least one lowercase letter (a-z).';
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one number (0-9).';
        }
        if (!preg_match('/[@$!%*?&]/', $password)) {
            $errors[] = 'Password must contain at least one special character (@, $, !, %, *, ?, &).';
        }

        // If there are validation errors, return them
        if (count($errors) > 0) {
            return back()->withErrors(['password' => $errors])->withInput();
        }

        // If validation passes, hash the password and store the user
        User::create([
            'email' => $email,
            'password' => $password, // Hash the password
        ]);

        // Redirect to login with success message
        return redirect()->route('login')->with('success', 'Account successfully created!');
    }
}
