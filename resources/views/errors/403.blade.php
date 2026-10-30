<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>403 – دسترسی غیرمجاز</title>
    @vite('resources/css/app.css')
    <style>
        @font-face {
            font-family: 'shabnam';
            src: url('{{ asset('assets/fonts/shabnam/Shabnam-Medium.woff2') }}');
        }

        body {
            font-family: 'shabnam', sans-serif;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="text-center">
        <h1 class="display-1 fw-bold text-dark">403</h1>
        <p class="text-dark fw-medium fs-18">شما اجازه دسترسی به این صفحه را ندارید.</p>
        <p class="text-dark fw-medium fs-13">در صورت نیاز، با مدیر سایت تماس بگیرید.</p>
        <a href="{{ route('home') }}" class="mt-3 btn border-secondary fs-13 rounded-3 px-20 py-2">بازگشت به صفحه اصلی</a>
    </div>
</body>

</html>