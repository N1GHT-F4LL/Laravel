<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        } else {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Invalid login credentials']);
        }
    }

    public function showSignupForm()
    {
        return view('auth.signup');
    }

    public function signup(Request $request)
    {
        // Validate signup data
        $this->validate($request, [
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,teacher,student',
        ]);

        // Create new user
        $user = User::create([
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
        ]);

        // Set the default name to username
        $user->name = $user->username;
        $user->save();

        // Login the user
        Auth::login($user);

        // Redirect to home page
        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
