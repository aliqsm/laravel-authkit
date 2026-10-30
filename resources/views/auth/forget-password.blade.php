@extends('authkit::layouts.auth')
@section('page_title', 'فراموشی رمز عبور')

@vite(['resources/js/auth/forgot-password.js'])



@section('content')
    <form id="forgot-password-form" action="{{ route('password.email') }}" method="POST" novalidate class="w-100 position-absolute top-50 start-50 translate-middle w-100 bg-white">
        @csrf

        <h1 class="fs-20 fw-bold text-dark">فراموشی رمز عبور</h1>
        <p class="fw-light text-secondary fs-14 fs-md-500 text-start mb-35">ایمیل خود را وارد کنید تا لینک بازیابی برایتان ارسال شود.</p>

        <div class="position-relative">
            <label class="form-group rounded-3 fw-light p-14 d-flex align-items-center justify-content-between gap-2">
                <input type="email" name="email" class="form-control rounded-0 border-0 p-0" placeholder=" " inputmode="email" required autocomplete="off">
                <span class="form-label text-secondary fw-light fs-13">ایمیل</span>
                <x-authkit::icons.sms-icon color="var(--secondary)" />
            </label>
        </div>
        <small id="email_error" class="fw-medium text-danger fs-12 ps-1 mt-1 d-none"></small>

        <button type="submit" class="btn btn-primary w-100 mt-30 py-14 rounded-3 fw-medium fs-14">ارسال لینک بازیابی</button>
        <a href="{{ route('login') }}" class="d-block text-secondary text-decoration-none mt-16 text-center fw-medium fs-13">بازگشت به ورود</a>
    </form>
@endsection
