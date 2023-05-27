<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
            'password' => ['required', 'string', 'min:6', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            if ($errors->has('password')) {
                $passwordErrors = $errors->get('password');

                foreach ($passwordErrors as $passwordError) {
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
        try {
            $request->validate([
                'username' => 'required|unique:users',
                'password' => ['required', 'min:6', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
                'role' => 'required|in:admin,teacher,student',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed: ' . $e->getMessage());
            // Xử lý ngoại lệ validation nếu cần thiết
            // Ví dụ: Đưa ra thông báo lỗi cho người dùng
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        }

        // Tiếp tục xử lý khi dữ liệu đã được validate

        // Tạo người dùng mới
        $user = User::create([
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
        ]);

        // Gán giá trị mặc định cho full_name
        $user->full_name = $user->username;
        $user->save();

        // Đăng nhập người dùng
        Auth::login($user);

        // Chuyển hướng đến trang chủ
        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
