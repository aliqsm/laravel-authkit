@extends('authkit::layouts.auth')
@section('page_title', 'عضویت')

@vite(['resources/js/auth/register.js'], 'vendor/authkit/build')



@section('content')
    <div class="position-absolute top-50 start-50 translate-middle w-100 bg-white">

        <h1 class="fs-20 fw-bold text-dark">ساخت حساب کاربری</h1>
        <p class="fw-light text-secondary fs-14 fs-md-500 text-start mb-35">اطلاعات مورد نیاز را جهت ساخت حساب کاربری وارد نمایید.</p>


        <form id="register-form" action="{{ route('register') }}" method="POST" novalidate class="w-100">
            @csrf

            <div class="position-relative">
                <label class="form-group rounded-3 fw-light p-14 d-flex align-items-center justify-content-between gap-2">
                    <input type="text" name="name" class="form-control rounded-0 border-0 p-0" placeholder=" " required autocomplete="off" autofocus>
                    <span class="form-label text-secondary fw-light fs-13">نام</span>
                    <x-authkit::icons.user-icon3 color="var(--secondary)" />
                </label>
            </div>
            <span id="name_error" class="fw-medium text-danger fs-12 ms-1 mt-2 d-none"></span>

            <div class="position-relative mt-20 mt-md-400">
                <label class="form-group rounded-3 fw-light p-14 d-flex align-items-center justify-content-between gap-2">
                    <input type="email" name="email" class="form-control rounded-0 border-0 p-0" placeholder=" " required autocomplete="off">
                    <span class="form-label text-secondary fw-light fs-13">ایمیل</span>
                    <x-authkit::icons.sms-icon color="var(--secondary)" />
                </label>
            </div>
            <span id="email_error" class="fw-medium text-danger fs-12 ms-1 mt-2 d-none"></span>

            <div class="position-relative mt-20 mt-md-400">
                <label class="form-group rounded-3 fw-light p-14 d-flex align-items-center justify-content-between gap-2">
                    <input type="password" name="password" class="form-control rounded-0 border-0 p-0" placeholder=" " required autocomplete="off">
                    <span class="form-label text-secondary fw-light fs-13">گذرواژه</span>
                    <x-authkit::icons.lock-icon color="var(--secondary)" />
                </label>
            </div>
            <span id="password_error" class="fw-medium text-danger fs-12 ms-1 mt-2 d-none"></span>

            <div class="position-relative mt-20 mt-md-400">
                <label class="form-group rounded-3 fw-light p-14 d-flex align-items-center justify-content-between gap-2">
                    <input type="password" name="password_confirmation" class="form-control rounded-0 border-0 p-0" placeholder=" " required autocomplete="off">
                    <span class="form-label text-secondary fw-light fs-13">تکرار گذرواژه</span>
                    <x-authkit::icons.lock-icon color="var(--secondary)" />
                </label>
            </div>
            <span id="password_confirmation_error" class="fw-medium text-danger fs-12 ms-1 mt-1 d-none"></span>

            <button type="submit" class="btn btn-primary w-100 mt-30 py-14 rounded-3 fw-medium fs-14">تایید و عضویت</button>
        </form>

        @if (config('authkit.features.google_login', true))
            <div class="d-flex align-items-center gap-2 mt-16">
                <hr class="flex-grow-1 my-0">
                <span class="text-secondary fs-13">یا</span>
                <hr class="flex-grow-1 my-0">
            </div>

            <a href="{{ route('oauth.google.redirect') }}" class="btn border-secondary w-100 mt-16 py-14 rounded-3 fw-medium fs-14 d-flex align-items-center justify-content-center gap-2">
                <x-authkit::icons.google-icon :width="20" :height="20" />
                ثبت نام با گوگل
            </a>
        @endif

        <p class="mb-0 mt-20 text-center text-secondary fw-medium fs-13">قبلاً ثبت‌نام کرده‌اید؟
            <a href="{{ route('login') }}" class="text-primary">وارد شوید</a>
        </p>
    </div>
@endsection
