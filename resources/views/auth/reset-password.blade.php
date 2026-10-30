@extends('authkit::layouts.auth')
@section('page_title', 'بازنشانی رمز عبور')

@vite(['resources/js/auth/reset-password.js'])



@section('content')
    <form id="reset-password-form" action="{{ route('password.update') }}" method="POST" novalidate class="w-100 position-absolute top-50 start-50 translate-middle w-100 bg-white">
        @csrf

        <h1 class="fs-20 fw-bold text-dark">بازنشانی رمز عبور</h1>
        <p class="fw-light text-secondary fs-14 fs-md-500 text-start mb-35">لطفاً رمز عبور جدید خود را وارد کرده و تأیید کنید.</p>

        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="position-relative">
            <label class="form-group rounded-3 fw-light p-14 d-flex align-items-center justify-content-between gap-2">
                <input type="password" name="password" class="form-control rounded-0 border-0 p-0" placeholder=" " required autocomplete="off" autofocus>
                <span class="form-label text-secondary fw-light fs-13">گذرواژه</span>
                <x-icons.lock-icon color="var(--secondary)" />
            </label>
        </div>
        <small id="password_error" class="fw-medium text-danger fs-12 ps-1 mt-1 d-none"></small>

        <div class="position-relative mt-20 mt-md-400">
            <label class="form-group rounded-3 fw-light p-14 d-flex align-items-center justify-content-between gap-2">
                <input type="password" name="password_confirmation" class="form-control rounded-0 border-0 p-0" placeholder=" " required autocomplete="off">
                <span class="form-label text-secondary fw-light fs-13">تکرار گذرواژه</span>
                <x-icons.lock-icon color="var(--secondary)" />
            </label>
        </div>
        <small id="password_confirmation_error" class="fw-medium text-danger fs-12 ps-1 mt-1 d-none"></small>

        <button type="submit" class="btn btn-primary w-100 mt-30 py-14 rounded-3 fw-medium fs-14">ذخیره رمز عبور جدید</button>
        <a href="{{ route('dashboard') }}" class="d-block text-secondary text-decoration-none mt-16 text-center fw-medium fs-14">انصراف</a>
    </form>
@endsection
