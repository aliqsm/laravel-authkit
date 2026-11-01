<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="dark">
    <title>@yield('title')</title>

    <style>
        @font-face {
            font-family: 'AuthKitFont';
            src: url('{{ asset('vendor/authkit/fonts/shabnam/Shabnam-Light.woff2') }}') format('woff2');
            font-weight: 300;
            font-display: swap;
        }

        @font-face {
            font-family: 'AuthKitFont';
            src: url('{{ asset('vendor/authkit/fonts/shabnam/Shabnam-Medium.woff2') }}') format('woff2');
            font-weight: 500;
            font-display: swap;
        }

        @font-face {
            font-family: 'AuthKitFont';
            src: url('{{ asset('vendor/authkit/fonts/shabnam/Shabnam-Bold.woff2') }}') format('woff2');
            font-weight: 700;
            font-display: swap;
        }


        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            padding: 24px 12px;
            background: #111;
            color: #fff;
            font-family: 'AuthKitFont', Tahoma, sans-serif;
            direction: rtl;
        }

        .wrapper {
            width: 100%;
            max-width: 430px;
            margin: 0 auto;
        }

        .content {
            padding: 32px 26px;
            background: #171717;
            border: 1px solid #292929;
            border-radius: 14px;
        }

        p {
            color: #999;
            font-size: 13px;
            line-height: 2.3;
        }

        .title {
            color: #fff;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            line-height: 1.8;
        }

        .details {
            margin: 25px 0;
            padding: 14px 16px;
            border: 1px solid #303030;
            border-radius: 12px;
        }

        .detail {
            margin-bottom: 10px;
        }

        .detail:last-child {
            margin-bottom: 0;
        }

        .detail-label {
            display: inline-block;
            min-width: 110px;
            color: #999;
            font-size: 12px;
            line-height: 2.3;
        }

        .detail-value {
            color: #eee;
            font-size: 12px;
            line-height: 2.3;
        }

        .actions {
            margin-top: 8px;
            padding-right: 22px;
            color: #c4c4c4;
            font-size: 12px;
            line-height: 2.5;
        }

        .button {
            display: block;
            margin-top: 20px;
            padding: 13px 18px;
            border-radius: 8px;
            background: #fff;
            color: #111 !important;
            text-align: center;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
        }

        .footer {
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid #303030;
            color: #666;
            text-align: center;
            font-size: 11px;
            line-height: 2;
        }

        @media screen and (max-width: 480px) {
            body {
                padding: 12px;
            }

            .content {
                padding: 26px 20px;
            }

            .title {
                font-size: 19px;
            }
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <div class="content">
            @yield('content')

            <p class="footer">
                در صورت نیاز به راهنمایی، با تیم پشتیبانی ما در ارتباط باشید.<br>
                با احترام، تیم پشتیبانی {{ config('app.app_name') }}<br>
                © ۱۴۰۵ {{ config('app.app_name') }} | تمامی حقوق محفوظ است.
            </p>
        </div>
    </div>

</body>

</html>
