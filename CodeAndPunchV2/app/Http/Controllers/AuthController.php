<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the username and password fields
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Prepare the credentials for login attempt
        $attemptCredentials = [
            'username' => $credentials['username'],
            'password' => $credentials['password'],
        ];

        // Validate the credentials using custom validation rules
        $validator = Validator::make($attemptCredentials, [
            'username' => ['required', Rule::exists('users'), 'regex:/^[a-zA-Z0-9]+$/'],
            'password' => ['required', 'string', 'min:6', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
        ]);

        // If validation fails, handle the errors
        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($errors->has('password')) {
                $passwordErrors = $errors->get('password');

                foreach ($passwordErrors as $passwordError) {
                    // Modify the error messages for password field as needed
                    if ($passwordError === 'The password must be at least 6 characters.') {
                        $errors->add('password', 'The password must be at least 6 characters and meet the required format.');
                    } elseif ($passwordError === 'The password format is invalid.') {
                        $errors->add('password', 'The password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character.');
                    }
                }
            }

            return redirect()
                ->back()
                ->withErrors($errors)
                ->withInput();
        }

        // Check if "Remember Me" option is selected
        $remember = $request->filled('remember');

        // Attempt to authenticate the user with the provided credentials
        if (Auth::attempt($attemptCredentials, $remember)) {
            return redirect()->route('home');
        }

        // Failed login attempt, redirect back to the login page with error message
        return redirect()
            ->back()
            ->withErrors([
                'message' => 'Invalid credentials.',
            ])
            ->withInput();
    }

    public function showSignupForm()
    {
        return view('auth.signup');
    }

    public function signup(Request $request)
    {
        try {
            $request->validate([
                'username' => ['required', 'regex:/^[a-zA-Z0-9]+$/', 'unique:users'],
                'password' => ['required', 'min:6', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
            ]);
        } catch (ValidationException $e) {
            Log::error('Validation failed: ' . $e->getMessage());
            // Handle validation exception if necessary
            // Example: Show error message to the user
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        }

        //force new user role is student
        // Continue with processing the data once it has been validated

        // Create a new user
        $user = User::create([
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'role' => 'student', // Đặt giá trị "student" cho trường "role"
        ]);

        // Set a default value for full_name
        $user->full_name = $user->username;
        $user->save();

        // Log in the user
        Auth::login($user);

        // Redirect to the home page
        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}