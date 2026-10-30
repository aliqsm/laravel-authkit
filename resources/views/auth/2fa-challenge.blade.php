@extends('authkit::layouts.auth')
@section('page_title', 'تأیید ورود دو مرحله‌ای')

@vite(['resources/js/auth/two-factor-challenge.js'], 'vendor/authkit/build')


@section('content')
    <form id="two-factor-challenge-form" action="{{ route('two-factor.verify') }}" method="POST" novalidate class="w-100 position-absolute top-50 start-50 translate-middle w-100 bg-white">
        @csrf

        <h1 class="fs-20 fw-bold text-dark">تأیید ورود دو مرحله‌ای</h1>
        <p class="fw-light text-secondary fs-14 fs-md-500 text-start mb-35">برای ادامه، کد احراز هویت یا کد بازیابی خود را وارد کنید.</p>

        <div class="position-relative">
            <label class="form-group rounded-3 fw-light p-14 d-flex align-items-center justify-content-between gap-2">
                <input type="text" name="code" class="form-control rounded-0 border-0 p-0" placeholder=" " required inputmode="numeric" autocomplete="one-time-code">
                <span class="form-label text-secondary fw-light fs-13">کد تأیید یا بازیابی</span>
                <x-icons.key-icon color="var(--secondary)" />
            </label>
        </div>
        <small id="code_error" class="fw-medium text-danger fs-12 ps-1 mt-1 d-none"></small>

        <button type="submit" class="btn btn-primary w-100 mt-30 py-14 rounded-3 fw-medium fs-14">تأیید و ورود</button>
        <a href="{{ route('login') }}" class="d-block text-primary text-decoration-none mt-16 text-center fw-medium fs-13">بازگشت به ورود</a>
    </form>
@endsection
