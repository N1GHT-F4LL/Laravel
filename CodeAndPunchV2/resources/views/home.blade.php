<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code And Punch</title>
</head>

<body>
    <h1>Welcome to the Home Page</h1>

    @if (Auth::check())
        <p>Welcome, {{ Auth::user()->name }}!</p>
        <p>Your role: {{ Auth::user()->role }}</p>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @else
        <p>Please login or sign up to access the home page.</p>
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('signup') }}">Sign Up</a>
    @endif
</body>

</html>
