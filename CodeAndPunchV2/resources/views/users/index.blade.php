<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User List</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <h1>User List</h1>
    <ul>
        <div>
            <a href="{{ route('home') }}" class="btn btn-primary">Home Page</a>
        </div>
        @if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isTeacher()))
            <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
        @endif
        @if ($msg)
            <div class="alert alert-success">
                {{ $msg }}
            </div>
        @endif
        @foreach ($users as $user)
            <li>
                <p>Username: <a href="{{ route('users.profile', ['user' => $user->id]) }}">{{ $user->username }}</a></p>
                <p>Role: {{ $user->role }}</p>
            </li>
        @endforeach
    </ul>
</body>

</html>
