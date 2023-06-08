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
            <input class="input" name="email" type="email" id="email" value="{{ $user->email }}">
            <label class="label">Email</label>
        </div>
        <div class="form-group">
            <input class="input" name="phone" type="phone" id="phone" value="{{ $user->phone }}">
            <label class="label">Phone</label>
        </div>
        <div class="form-group">
            <input class="input" name="password" type="password" id="password" autocomplete="new-password">
            <label class="label">Password</label>
        </div>
        <div class="form-group">
            <input class="input" name="full_name" type="text" id="full_name" value="{{ $user->full_name }}">
            <label class="label">Fullname</label>
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
        <div class="button-container">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
