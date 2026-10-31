@extends('authkit::layouts.auth')
@section('page_title', 'ورود')

@vite(['resources/js/auth/login.js'], 'vendor/authkit/build')



@section('content')
    <div class="position-absolute top-50 start-50 translate-middle w-100 bg-white">

        <h1 class="fs-20 fw-bold text-dark">ورود به حساب کاربری</h1>
        <p class="fw-light text-secondary fs-14 fs-md-500 text-start mb-35">برای ادامه، اطلاعات حساب خود را وارد کنید.</p>


        <form id="login-form" action="{{ route('login') }}" method="POST" novalidate class="w-100">
            @csrf

            <div class="position-relative">
                <label class="form-group rounded-3 fw-light p-14 d-flex align-items-center justify-content-between gap-2">
                    <input type="email" name="email" class="form-control rounded-0 border-0 p-0" placeholder=" " value="reza@gmail.com" required autocomplete="off" autofocus>
                    <span class="form-label text-secondary fw-light fs-13">نام کاربری</span>
                    <x-authkit::icons.user-icon3 color="var(--secondary)" />
                </label>
            </div>
            <small id="email_error" class="fw-medium text-danger fs-12 ps-1 mt-1 d-none"></small>

            <div class="position-relative mt-20 mt-md-400">
                <label class="form-group rounded-3 fw-light p-14 d-flex align-items-center justify-content-between gap-2">
                    <input type="password" name="password" class="form-control rounded-0 border-0 p-0" placeholder=" " value="00" required autocomplete="off">
                    <span class="form-label text-secondary fw-light fs-13">گذرواژه</span>
                    <x-authkit::icons.lock-icon color="var(--secondary)" />
                </label>
            </div>
            <small id="password_error" class="fw-medium text-danger fs-12 ps-1 mt-1 d-none"></small>

            <div class="d-flex align-items-center justify-content-between mt-16">
                <label class="form-check-label text-secondary fw-medium fs-13 d-flex align-items-center justify-content-start gap-1">
                    <input type="checkbox" name="remember" value="1" style="width: 0.915rem; height: 0.915rem;">
                    مرا بخاطر بسپار
                </label>
                @if (config('authkit.features.password_reset', true))
                    <a href="{{ route('password.request') }}" class="fw-medium text-secondary fs-13">فراموشی رمز عبور؟</a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-30 py-14 rounded-3 fw-medium fs-14">ورود به حساب</button>
        </form>


        @if (config('authkit.features.google_login', true))
            <div class="d-flex align-items-center gap-2 mt-16">
                <hr class="flex-grow-1 my-0">
                <span class="text-secondary fs-13">یا</span>
                <hr class="flex-grow-1 my-0">
            </div>

            <a href="{{ route('oauth.google.redirect') }}" class="btn border-secondary w-100 mt-16 py-14 rounded-3 fw-medium fs-14 d-flex align-items-center justify-content-center gap-2">
                <x-authkit::icons.google-icon :width="20" :height="20" />
                ورود با گوگل
            </a>
        @endif

        @if (config('authkit.features.registration', true))
            <p class="mb-0 mt-20 text-center text-secondary fw-medium fs-13">حساب کاربری ندارید؟
                <a href="{{ route('register') }}" class="text-primary fs-13">ساخت حساب</a>
            </p>
        @endif
    </div>
@endsection
