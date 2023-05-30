<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You need to log in to access this page.');
        }
        // Lấy danh sách người dùng từ cơ sở dữ liệu
        $users = User::select('id', 'username', 'role')->get();
        $msg = session('msg');
        // Hiển thị danh sách người dùng và truyền thông báo 'msg'
        return view('users.index', ['users' => $users, 'msg' => $msg]);
    }



    public function create()
    {
        // Trả về view tạo mới người dùng
        return view('users.create');
    }
    public function store(Request $request)
    {
        try {
            // Kiểm tra role của người tạo user, chỉ admin và teacher được tạo mới user
            $isAdmin = auth()->user()->isAdmin();
            $isTeacher = auth()->user()->isTeacher();
            if (!$isAdmin && !$isTeacher) {
                Log::error('User creation fail because not authorized to create a user');
                abort(403, 'You are not authorized to create a user.');
            }
            // Kiểm tra tính hợp lệ của dữ liệu đầu vào
            $validator = Validator::make($request->all(), [
                'username' => ['required', 'regex:/^[a-zA-Z0-9]+$/', 'unique:users'],
                'password' => ['required', 'min:6', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
                'role' => 'required|in:student',
            ]);

            $validator->validate();

            // Create a new user
            $user = User::create([
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password')),
                'role' => $request->input('role'),
            ]);

            // Set a default value for full_name
            $user->full_name = $user->username;
            Log::info('User created successfully. Username: ' . $user->username . ' by user ' . auth()->user()->username);
            $user->save();

            return redirect()->route('users.index')->with('msg', 'User created successfully');
        } catch (ValidationException $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return redirect()->route('users.create')
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'User creation failed');
        }
    }

    public function profile($user_id)
    {
        // Lấy thông tin người dùng từ cơ sở dữ liệu
        $user = User::find($user_id);
        // Kiểm tra xem người dùng có tồn tại không
        if (!$user) {
            Log::error('User ' . auth()->user()->id . ' accessed profile of user ' . $user_id);
            // Nếu không tìm thấy người dùng, điều hướng về trang 404 hoặc thông báo lỗi tương ứng
            abort(404);
        }

        // Ghi log thông tin người dùng đã truy cập vào profile
        Log::info('User ' . auth()->user()->id . ' accessed profile of user ' . $user->id);

        // Trả về view profile.blade.php với dữ liệu người dùng
        return view('users.profile', ['user' => $user]);
    }

    public function edit(User $user)
    {
        // Kiểm tra xem người dùng có phải là giáo viên hay không
        $isTeacher = Auth::user()->isTeacher();
        $isStudentProfile = $user->isStudent();
        // Kiểm tra xem người dùng có quyền chỉnh sửa người dùng hiện tại hay không
        $canEdit = ($isTeacher && $isStudentProfile) || (Auth::id() === $user->id);

        // Kiểm tra xem người dùng có phải là quản trị viên hay không
        $isAdmin = Auth::user()->isAdmin();

        // Kiểm tra xem người dùng có quyền chỉnh sửa tất cả người dùng hay không
        $canEditAll = $isAdmin;

        // Kiểm tra xem người dùng có quyền chỉnh sửa người dùng hiện tại hoặc là người dùng sinh viên hay không
        if (!$canEdit && !$canEditAll) {
            Log::error('User edit fail');
            abort(403, 'You are not authorized to edit this user.');
        }
        Log::info('User edit');
        // Trả về view chỉnh sửa thông tin người dùng
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        try {
            // Kiểm tra xem người dùng có phải là giáo viên hay không
            $isTeacher = Auth::user()->isTeacher();
            $isStudentProfile = $user->isStudent();
            // Kiểm tra xem người dùng có quyền chỉnh sửa người dùng hiện tại hay không
            $canEdit = ($isTeacher && $isStudentProfile) || (Auth::id() === $user->id);
            // Kiểm tra xem người dùng có phải là quản trị viên hay không
            $isAdmin = Auth::user()->isAdmin();
            // Kiểm tra xem người dùng có quyền chỉnh sửa tất cả người dùng hay không
            $canEditAll = $isAdmin;
            // Kiểm tra xem người dùng có quyền chỉnh sửa hay không
            if (!$canEdit && !$canEditAll) {
                abort(403, 'You are not authorized to edit this user.');
            }

            // Validate dữ liệu đầu vào
            $validator = Validator::make($request->all(), [
                'email' => 'nullable|email',
                'phone' => 'nullable|numeric|min:10',
                'password' => ['nullable', 'min:6', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
                'full_name' => 'nullable|string|max:255',
                'role' => 'nullable|in:admin,teacher,student',
            ]);

            $validator->validate();

            // Cập nhật thông tin người dùng nếu người dùng đã nhập
            if ($request->filled('email')) {
                Log::info('User ' . auth()->user()->id . ' edit email of user ' . $user->id . ' to ' . $request->input('email'));
                $user->email = $request->input('email');
            }

            if ($request->filled('phone')) {
                Log::info('User ' . auth()->user()->id . ' edit phone of user ' . $user->id . ' to ' . $request->input('phone'));
                $user->phone = $request->input('phone');
            }

            if ($request->filled('full_name')) {
                Log::info('User ' . auth()->user()->id . ' edit full name of user ' . $user->id . ' to ' . $request->input('full_name'));
                $user->full_name = $request->input('full_name');
            }

            // Nếu có cung cấp mật khẩu mới, thì cập nhật mật khẩu
            if ($request->filled('password')) {
                Log::info('User ' . auth()->user()->id . ' edit password of user ' . $user->id);
                $user->password = Hash::make($request->input('password'));
            }

            // Chỉ cho phép quản trị viên cập nhật trường "role"
            if ($isAdmin && $request->filled('role')) {
                Log::info('User ' . auth()->user()->id . ' edit role of user ' . $user->id . ' to ' . $request->input('role'));
                $user->role = $request->input('role');
            }

            // Lưu thông tin người dùng
            $user->save();

            Log::info('User updated successfully');

            // Redirect về trang profile của người dùng sau khi cập nhật thành công
            return redirect()->route('users.profile', $user)->with('success', 'User updated successfully');
        } catch (ValidationException $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return redirect()->route('users.edit', $user)
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'User update failed');
        }
    }


    public function destroy(User $user)
    {
        // Kiểm tra xem người dùng hiện tại có quyền xoá tài khoản hay không
        if (auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $user->isStudent()) || ($user->id == auth()->user()->id)) {
            // Xoá người dùng
            $user->delete();
            // Redirect về danh sách người dùng 
            Log::info('Delete user successfully');
            return redirect()->route('users.index')->with('success', 'User deleted successfully');
        }
        Log::info('Delete user failed');
        // Nếu không có quyền, redirect về trang không có quyền truy cập
        return redirect()->route('access-denied')->with('error', 'Access denied');
    }
}