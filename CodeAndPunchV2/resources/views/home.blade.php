<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code And Punch</title>
</head>

<body>
    <h1>Team 1</h1>
    @if (Auth::check())
        <p>Welcome, {{ Auth::user()->full_name }}!</p>
        <p>Your role: {{ Auth::user()->role }}</p>
        <ul>
            <li><a href="{{ route('home') }}">Home</a></li>
            @auth
                <li><a href="{{ route('users.index') }}">Manage Users</a></li>
                <li><a href="{{ route('users.profile', ['user' => Auth::user()->id]) }}">My Profile</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-button">
                            Logout
                        </button>
                    </form>
                </li>
            @endauth
        </ul>
    @else
        <p>Please login or sign up to access the home page.</p>
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('signup') }}">Sign Up</a>
    @endif
</body>

</html>
