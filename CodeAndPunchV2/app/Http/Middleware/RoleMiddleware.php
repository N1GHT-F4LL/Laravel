<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
   public function handle($request, Closure $next, ...$roles)
   {
      // Kiểm tra xem người dùng đã đăng nhập chưa
      if (!Auth::check()) {
         return redirect()->route('login')->with('error', 'You must be logged in to access this page');
      }

      // Lấy vai trò của người dùng hiện tại
      $user = Auth::user();

      // Kiểm tra xem vai trò của người dùng có trong danh sách vai trò cho phép hay không
      if ($user->isAdmin() || $user->isTeacher()) {
         return $next($request);
      }

      // Nếu không có quyền truy cập, redirect về trang không có quyền hoặc trang khác tùy theo yêu cầu của bạn
      return redirect()->route('access-denied')->with('error', 'Access denied');
   }
}