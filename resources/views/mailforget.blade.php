<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @section('title')
        Login
    @endsection
    @include('admin.layouts.title-meta')
    @include('admin.layouts.header')
</head>
<body>

    <h1>Reset Password</h1>
    <p>You requested a password reset. Click the link below to reset your password:</p>
    <a href="{{ url('reset-password/' . $token) }}">Reset Password</a>
    <p>If you did not request this, please ignore this email.</p>

    @include('admin.layouts.scripts')
</body>
</html>
