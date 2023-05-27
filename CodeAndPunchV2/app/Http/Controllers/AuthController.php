<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $attemptCredentials = [
            'username' => $credentials['username'],
            'password' => $credentials['password'],
        ];

        $validator = Validator::make($attemptCredentials, [
            'username' => ['required', Rule::exists('users')],
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Invalid login credentials']);
        }

        if (Auth::attempt($attemptCredentials)) {
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
        //nfconfig
        //dd($request->all());
        // Validate signup data
        Log::info('Đã gọi phương thức signup');
        ///////////////////////////////////
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

        return redirect()->route('home');
    }
}
