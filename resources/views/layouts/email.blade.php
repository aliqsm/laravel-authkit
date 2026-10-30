<!doctype html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="utf-8">
    <style>
        @font-face {
            font-family: 'Shabnam';
            src: url("{{ asset('assets/fonts/shabnam/Shabnam-Light.woff2') }}") format("woff2"),
                font-weight: normal;
            font-style: normal;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #222;
            font-family: 'Shabnam', Tahoma, Arial, sans-serif;
            direction: rtl;
        }

        .wrapper {
            width: 100%;
            padding: 24px 0;
            background: #222;
        }

        .container {
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
            background-color: #333;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.5);
            border: 1px solid #444;
        }

        .header {
            background-color: #222;
            color: #ffffff;
            text-align: center;
            font-weight: bold;
            padding: 16px;
            font-size: 16px;
            border-bottom: 1px solid #444;
        }

        .content {
            padding: 24px;
        }

        .title {
            font-size: 15px;
            font-weight: 600;
            margin: 0 0 12px 0;
            color: #ffffff;
        }

        .text {
            font-size: 14px;
            color: #cfcfcf;
            line-height: 1.8;
            margin: 0 0 16px 0;
            text-align: justify;
        }

        .link {
            display: block;
            font-size: 13px;
            color: #2077d8;
            direction: ltr;
            word-break: break-all;
            margin-top: 12px;
            text-align: left;
        }

        .btn {
            display: block;
            margin-top: 16px;
            padding: 12px;
            background-color: #2077d8;
            color: #ffffff !important;
            text-decoration: none;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
        }

        .btn:hover {
            background-color: #1a63b6;
        }

        .info {
            margin-top: 32px;
            font-size: 13px;
            color: #b5b5b5;
            line-height: 1.8;
        }

        .contact {
            margin-top: 16px;
            font-size: 12px;
            color: #e5e5e5;
        }

        .footer {
            background-color: #222;
            text-align: center;
            font-size: 12px;
            color: #aaa;
            padding: 14px;
            border-top: 1px solid #444;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">

            <div class="header">
                @yield('title')
            </div>


            <div class="content">
                @yield('content')
            </div>


            <div class="footer">
                <div class="contact">
                    <p>در صورت بروز مشکل می‌توانید با پشتیبانی تماس بگیرید.</p>
                    <p>ایمیل: support@yourproject.com</p>
                    <p>تیم پشتیبانی: {{ env('APP_NAME') }}</p>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
