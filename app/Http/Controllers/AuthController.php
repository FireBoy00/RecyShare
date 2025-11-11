<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Handle logout POST
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
    // Show login form
    public function showLogin()
    {
        return view('login');
    }

    // Show signup form
    public function showSignup()
    {
        return view('signup');
    }

    // Handle signup POST
    public function signup(Request $request)
    {
        $request->validate([
            'username' => ['required', 'unique:users,username', 'max:255', 'regex:/^[a-z0-9._-]+$/'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'username.regex' => 'Username must be lowercase and can only contain letters, numbers, hyphens, underscores, and periods.',
        ]);

        $username = $request->input('username');
        $user = User::create([
            'username' => $username,
            'display_name' => $username,
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Account created and logged in!');
    }

    // Handle login POST
    public function login(Request $request)
    {
        // Validate the login request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Logged in successfully!');
        }
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
}
