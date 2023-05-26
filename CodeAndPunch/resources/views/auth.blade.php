<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Authentication</title>
   <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@yield('title')</div>

                <div class="card-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
