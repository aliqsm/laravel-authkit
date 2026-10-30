<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>500 – خطای داخلی سرور</title>
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
        <h1 class="display-1 fw-bold text-dark">500</h1>
        <p class="text-dark fw-medium fs-18">خطایی در سرور رخ داده است.</p>
        <p class="text-dark fw-medium fs-13">لطفاً کمی بعد دوباره تلاش کنید.</p>
        <a href="{{ route('home') }}" class="mt-3 btn border-secondary fs-13 rounded-3 px-20 py-2">بازگشت به صفحه اصلی</a>
    </div>
</body>

</html>