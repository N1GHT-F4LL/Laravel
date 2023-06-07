<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code And Punch</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<style>
    p {
        text-align: center;
    }
</style>

<body>
    @if (Auth::check())
        <p>Welcome, {{ Auth::user()->full_name }}!</p>
        <p>Your role: {{ Auth::user()->role }}</p>
        <ul>
            <li><a href="{{ route('home') }}">Home</a></li>
            @auth
                <li><a href="{{ route('users.index') }}">Manage Users</a></li>
                <li><a href="{{ route('users.profile', ['user' => Auth::user()->id]) }}">My Profile</a></li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-button">
                        Logout
                    </button>
                </form>
            @endauth
        </ul>
    @else
        <div class="container">
            <div class="card">
                <div class="card-header">Team 1</div>
                <div class="card-body">
                    <p>Please login or sign up to access this page.</p>
                    <div class="button-container">
                        <button onclick="window.location.href='{{ route('login') }}'">Login</button>
                        <button onclick="window.location.href='{{ route('signup') }}'">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</body>

</html>
