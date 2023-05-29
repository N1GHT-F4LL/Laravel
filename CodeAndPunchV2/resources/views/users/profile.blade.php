<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>

<body>
    <h1>User Profile</h1>

    <ul>
        <li>
            <strong>Username:</strong> {{ $user->username }}
        </li>
        <li>
            <strong>Full Name:</strong> {{ $user->full_name }}
        </li>
        <li>
            <strong>Email:</strong> {{ $user->email }}
        </li>
        <li>
            <strong>Phone:</strong> {{ $user->phone }}
        </li>
        <li>
            <strong>Role:</strong> {{ $user->role }}
        </li>
        <li>
            <strong>Password:</strong> ********
        </li>
    </ul>

    @if (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isTeacher()))
        @if (auth()->user()->isAdmin() || (auth()->user()->isTeacher() && !$user->isAdmin()))
            <form action="{{ route('users.edit', ['user' => $user->id]) }}" method="GET">
                @csrf
                <button type="submit">Edit</button>
            </form>
            <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        @endif
    @endif
</body>

</html>
