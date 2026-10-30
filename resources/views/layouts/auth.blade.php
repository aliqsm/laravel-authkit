<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" href="{{ asset('assets/media/image/favicon.png') }}">
    <title>{{ env('APP_NAME') }}</title>
    <meta name="theme-color" content="#5867dd">
    <title>@yield('page_title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/css/auth/layout.css', 'resources/js/app.js'], 'vendor/authkit/build')
</head>

<body>
    <div class="container-fluid px-0 px-md-2">
        <div class="main-container container px-16 py-30 position-relative">
            @yield('content')
        </div>
    </div>
</body>

</html>
