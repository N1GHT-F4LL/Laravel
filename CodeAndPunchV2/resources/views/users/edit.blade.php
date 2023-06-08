@extends('auth')

@section('title', 'Edit User')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@section('content')

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')
        <!-- Các trường chỉnh sửa thông tin người dùng -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="{{ $user->full_name }}">
        </div>

        @if (Auth::user()->isAdmin())
            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role">
                    <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Student
                    </option>
                    <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Teacher
                    </option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin
                    </option>
                </select>
            </div>
        @endif

        <!-- Button Submit -->
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
