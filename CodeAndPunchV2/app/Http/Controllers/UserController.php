<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Lấy danh sách người dùng từ cơ sở dữ liệu
        $users = User::all();

        // Trả về view hiển thị danh sách người dùng
        return view('users.index', compact('users'));
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

    public function profile(User $user)
    {
        // Trả về view hiển thị thông tin chi tiết người dùng
        // ...
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
        // Xử lý xoá người dùng khỏi cơ sở dữ liệu
        // ...

        // Trả về view hoặc redirect về danh sách người dùng
        // ...
    }
}