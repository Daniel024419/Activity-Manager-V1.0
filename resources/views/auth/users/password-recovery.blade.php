<!DOCTYPE html>
<html lang="en">

<head>
    <title>Account | Recovery</title>
    @include('auth.includes.head')
</head>

<body>
    <div class="login-container">
        <form id="loginForm" action="{{ route('account.recovery.user.post') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <h2>User Account Recovery</h2>

            <!-- Email Field -->
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                <small>Error message</small>
            </div>

            <div style="padding: 10px"><a href="{{ route('auth.user.login') }}">Login now?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit">Find Account</button>

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

</body>

</html>
