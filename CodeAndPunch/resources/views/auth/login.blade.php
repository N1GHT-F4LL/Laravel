@extends('auth')

@section('title', 'Log In')

@section('content')
    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Log In</button>
    </form>
@endsection