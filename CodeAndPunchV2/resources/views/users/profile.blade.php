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

    @if (auth()->check())
        @if (auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $user->isStudent()))
            <form action="{{ route('users.edit', ['user' => $user->id]) }}" method="GET">
                @csrf
                <button type="submit">Edit</button>
            </form>
            <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        @elseif (auth()->user()->id == $user->id)
            <form action="{{ route('users.edit', ['user' => $user->id]) }}" method="GET">
                @csrf
                <button type="submit">Edit</button>
            </form>
            @if (auth()->user()->isAdmin() || (auth()->user()->isTeacher() && $user->isStudent()))
                <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            @endif
        @endif
    @endif

</body>

</html>

tôi là user a, b là user profile mà tôi đang xem
nếu tôi xem profile của user b là profile user a thì được phép chỉnh sửa (a.id = b.id thì được phép sửa và xoá)
nếu tôi là admin thì được sửa và xoá tất cả (a.role = 'admin' thì được phép sửa và xoá, không cần quan tâm b là gì)
nếu tôi là teacher thì được sửa và xoá của student(a.role = teacher && b.role = student thì được phép sửa và xoá)

