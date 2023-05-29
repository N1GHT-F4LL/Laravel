<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Lấy danh sách người dùng từ cơ sở dữ liệu
        $users = User::select('id', 'username', 'role')->get();
        // Hiển thị danh sách người dùng và dừng thực thi
        //dd($users);
        return view('users.index', ['users' => $users]);
    }


    public function create()
    {
        // Trả về view tạo mới người dùng
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Xử lý lưu thông tin người dùng vào cơ sở dữ liệu
        // ...

        // Trả về view hoặc redirect về danh sách người dùng
        // ...
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
        // Trả về view chỉnh sửa thông tin người dùng
        // ...
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
        if (auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $user->isStudent())) {
            // Xoá người dùng
            $user->delete();
            // Redirect về danh sách người dùng hoặc trang khác tùy theo yêu cầu của bạn
            return redirect()->route('users.index')->with('success', 'User deleted successfully');
        }
        // Nếu không có quyền, redirect về trang không có quyền truy cập hoặc trang khác tùy theo yêu cầu của bạn
        return redirect()->route('access-denied')->with('error', 'Access denied');
    }
}