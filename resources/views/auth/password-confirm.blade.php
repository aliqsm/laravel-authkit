@extends('authkit::layouts.auth')
@section('page_title', 'تأیید رمز عبور')

@vite(['resources/js/auth/password-confirm.js'])



@section('content')
    <div class="position-absolute top-50 start-50 translate-middle w-100 bg-white">
        <form id="password-confirm-form" action="{{ route('password.confirm.verify') }}" method="POST" novalidate class="w-100">
            @csrf

            <h1 class="fs-20 fw-bold text-dark">تأیید رمز عبور</h1>
            <p class="fw-light text-secondary fs-14 fs-md-500 text-start mb-35">برای ادامه، لطفاً رمز عبور حساب کاربری خود را جهت تأیید هویت وارد نمایید.</p>

            <div class="position-relative">
                <label class="form-group rounded-3 fw-light p-14 @error('password') is-invalid @enderror d-flex align-items-center justify-content-between gap-2">
                    <input type="password" name="password" class="form-control rounded-0 border-0 p-0" placeholder=" " required autocomplete="current-password" autofocus>
                    <span class="form-label text-secondary fw-light fs-13">گذرواژه</span>
                    <x-icons.lock-icon color="var(--secondary)" />
                </label>
            </div>
            <small id="password_error" class="fw-medium text-danger fs-12 ps-1 mt-1 d-none"></small>

            <button type="submit" class="btn btn-primary w-100 mt-20 py-14 rounded-3 fw-medium fs-14">تأیید و ادامه</button>
        </form>

        
        <form id="password-reset-link-form" action="{{ route('password.send-reset-link') }}" method="POST" class="mt-16 text-center">
            @csrf
            <span class="text-secondary fs-13">رمز عبور خود را فراموش کرده‌اید؟</span>
            <button type="submit" class="btn btn-link p-0 ms-1 fs-13 fw-medium text-primary text-decoration-none">بازیابی رمز عبور</button>
        </form>
    </div>
@endsection
