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
                <small>Error message</small>
            </div>

            <!-- Password Field -->
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                <small>Error message</small>
            </div>

            <!-- Submit Button -->
            <button type="submit">Login</button>

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
