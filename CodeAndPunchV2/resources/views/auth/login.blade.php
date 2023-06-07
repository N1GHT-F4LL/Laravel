@extends('auth')

@section('title', 'Log In')

@section('content')
    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-group">
            <input class="input" name="username" type="text" id="username" required="" autocomplete="new-password">
            <label class="label">Username</label>
        </div>
        <div class="form-group">
            <input class="input" name="password" type="password" id="password" required="" autocomplete="new-password">
            <label class="label">Password</label>
        </div>
        <div class="form-group">
            <div class="form-check">
                <div class="checkbox-wrapper-4">
                    <input type="checkbox" id="remember" name="remember" class="inp-cbx">
                    <label for="remember" class="cbx"><span>
                            <svg height="10px" width="12px">
                            </svg></span><span>Remember Me</span></label>
                    <svg class="inline-svg">
                        <symbol viewBox="0 0 12 10" id="check-4">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </symbol>
                    </svg>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Log In</button>
    </form>
    <div>
        <form action="{{ route('signup') }}" method="GET">
            <div class="button-container">
                <div>Or, you already have account?</div>
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </div>
        </form>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
