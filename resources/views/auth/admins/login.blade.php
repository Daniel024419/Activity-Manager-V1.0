<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login | User</title>
    @include('auth.includes.head')
</head>

<body>
    <div class="login-container">
        <form id="loginForm" action="{{ route('auth.admin.login.post') }}" method="POST">
            @csrf
            <h2>Login | Admin</h2>

            <!-- Email Field -->
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                <small>{{ $errors->first('email') }}</small>
            </div>

            <!-- Password Field -->
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <small>{{ $errors->first('password') }}</small>
            </div>

            <div class="form-check mb-3" style="padding-bottom: 10px">
                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                <label class="form-check-label" for="remember">
                    Remember Me
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit">Login</button>

            <center style="padding: 10px"><a href="{{ route('account.recovery.admin.get') }}">Forgot Password?</a>
            </center>


            <!-- Error Messages -->
            @if ($errors->any())
                <div class="error-messages">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif


            @if (session('message'))
                <div class="error-messages">
                    <p>{{ session('message') }}</p>
                </div>
            @endif
        </form>
    </div>

    <script src="{{ asset('js/login.js') }}"></script>
</body>

</html>
