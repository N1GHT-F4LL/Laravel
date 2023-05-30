<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
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
            $user->save();

            return redirect()->route('users.index')->with('msg', 'User created successfully');
        } catch (ValidationException $e) {
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
            // Nếu không tìm thấy người dùng, điều hướng về trang 404 hoặc thông báo lỗi tương ứng
            abort(404);
        }

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
            abort(403, 'You are not authorized to edit this user.');
        }

        // Trả về view chỉnh sửa thông tin người dùng
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Xử lý cập nhật thông tin người dùng trong cơ sở dữ liệu
        // ...

        // Trả về view hoặc redirect về danh sách người dùng
        // ...
    }

    public function destroy(User $user)
    {
        // Kiểm tra xem người dùng hiện tại có quyền xoá tài khoản hay không
        if (auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $user->isStudent()) || ($user->id == auth()->user()->id)) {
            // Xoá người dùng
            $user->delete();
            // Redirect về danh sách người dùng 
            return redirect()->route('users.index')->with('success', 'User deleted successfully');
        }
        // Nếu không có quyền, redirect về trang không có quyền truy cập
        return redirect()->route('access-denied')->with('error', 'Access denied');
    }
}