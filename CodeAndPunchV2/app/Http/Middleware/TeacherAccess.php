<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra nếu người dùng có vai trò giáo viên
        if (Auth::check() && Auth::user()->role == 'teacher') {
            // Nếu tài khoản đích là role student hoặc tài khoản đích là chính người dùng hiện tại
            if ($request->route('user') && ($request->route('user')->role == 'student' || $request->route('user')->id == Auth::user()->id)) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized');
    }
}