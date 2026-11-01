<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('assets/media/image/favicon.png') }}">
    <title>{{ env('APP_NAME') }}</title>
    <meta name="theme-color" content="#5867dd">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/css/auth/layout.css', 'resources/js/app.js', 'resources/js/auth/logout.js'], 'vendor/authkit/build')
</head>

<body>

    <div class="container-fluid p-0">
        <div class="authkit-dashboard-layout container w-100 py-5">
            @yield('content')
        </div>
    </div>

</body>

</html>
