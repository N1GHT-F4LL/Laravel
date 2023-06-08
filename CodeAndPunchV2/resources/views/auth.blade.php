<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Authentication')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">@yield('title')</div>
            <div class="card-body">
                @yield('content')
                @auth
                    <div>
                        <form action="{{ route('users.index') }}" method="GET">
                            <div class="button-container manage-user-button">
                                <button type="submit" class="btn btn-primary">Manage Users</button>
                            </div>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</body>

</html>
