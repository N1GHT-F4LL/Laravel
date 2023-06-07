@extends('auth')

@section('title', 'Sign Up')

@section('content')
    <div>
        <div>
            <form method="POST" action="{{ route('signup.post') }}">
                @csrf
                <div class="form-group">
                    <input class="input" name="username" type="text" id="username" required=""
                        autocomplete="new-password">
                    <label class="label">Username</label>
                </div>
                <div class="form-group">
                    <input class="input" name="password" type="password" id="password" required=""
                        autocomplete="new-password">
                    <label class="label">Password</label>
                </div>
                <div class="button-container">
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                </div>
            </form>
        </div>

        <div>
            <form action="{{ route('login') }}" method="GET">
                <div class="button-container">
                    <div>or</div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
