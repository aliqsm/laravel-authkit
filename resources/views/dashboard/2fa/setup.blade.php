@extends('authkit::layouts.dashboard')
@section('page_title', 'فعال‌سازی تایید دو مرحله‌ای')

@vite(['resources/js/auth/two-factor-setup.js'], 'vendor/authkit/build')



@section('content')

    <!-- ----------------------------------- -->
    <!-- Two-Factor Authentication Setup -->
    <!-- ----------------------------------- -->
    <div class="card">

        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h3 class="m-0 fw-bold fs-18">فعال‌سازی احراز هویت دو مرحله‌ای</h3>
            <a href="{{ route('dashboard') }}" class="p-1">
                <x-authkit::icons.arrow-left-icon color="var(--secondary)" />
            </a>
        </div>

        <form id="two-factor-enable-form" action="{{ route('two-factor.enable') }}" method="POST" novalidate class="card-body">
            @csrf

            <div class="row g-4">
                <!-- ----------------------------------- -->
                <!-- Step 1: Scan QR Code -->
                <!-- ----------------------------------- -->
                <div class="col-md-6">
                    <div class="p-1 p-md-4">
                        <h2 class="fs-16 fw-bold text-dark mb-3">۱. اسکن QR کد</h2>

                        <p class="fw-light text-secondary fs-14 text-start">
                            برای ادامه، QR کد زیر را با اپلیکیشن احراز هویت گوشی خود اسکن کنید. در صورت نیاز، می‌توانید کلید راه‌اندازی را به‌صورت دستی وارد کنید.
                        </p>

                        <div class="text-center">
                            <div class="d-inline-block p-12 bg-light rounded-3 border border-light">
                                {!! $qrImage !!}
                            </div>
                        </div>

                        <div class="mt-20 bg-light border border-light rounded-3 p-2 d-flex align-items-center justify-content-end gap-3">
                            <span id="secret-key" class="font-monospace overflow-x-auto" dir="ltr">{{ $secret }}</span>
                            <button type="button" id="copy-2fa-secret" class="bg-transparent border-0 flex-shrink-0 p-1" style="min-width: 30px; min-height: 30px; outline:none !important" data-secret="{{ $secret }}">
                                <span class="copy-icon">
                                    <x-authkit::icons.copy-icon2 :width="22" :height="22" color="var(--secondary)" />
                                </span>
                                <span class="tick-icon d-none">
                                    <x-authkit::icons.tick-icon :width="18" :height="18" color="var(--secondary)" />
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ----------------------------------- -->
                <!-- Step 2: Verify OTP -->
                <!-- ----------------------------------- -->
                <div class="col-md-6">
                    <div class="p-1 p-md-4">
                        <h2 class="fs-16 fw-bold text-dark mb-3">۲. وارد کردن کد تأیید</h2>

                        <p class="fw-light text-secondary fs-14 mb-3">
                            پس از اسکن QR کد، اپلیکیشن احراز هویت یک کد ۶ رقمی تولید می‌کند. این کد برای تأیید مالکیت کلید راه‌اندازی و تکمیل فرایند فعال‌سازی استفاده می‌شود.
                        </p>

                        <p class="fw-light text-secondary fs-14 mb-4">
                            کد نمایش‌داده‌شده در اپلیکیشن را در کادر زیر وارد کنید. پس از تأیید صحت کد، احراز هویت دو مرحله‌ای برای حساب شما فعال خواهد شد.
                        </p>

                        <div class="position-relative">
                            <label class="form-group rounded-3 fw-light p-14 d-flex align-items-center justify-content-between gap-2">
                                <input type="text" name="code" class="form-control rounded-0 border-0 p-0 text-center" placeholder=" " maxlength="6" required autocomplete="off" inputmode="numeric" pattern="[0-9]{6}">
                                <span class="form-label text-secondary fw-light fs-13">کد ۶ رقمی</span>
                                <x-authkit::icons.key-icon color="var(--secondary)" />
                            </label>
                            <span id="code_error" class="fw-medium text-danger fs-12 ms-1 mt-1 d-none"></span>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- ----------------------------------- -->
        <!-- Submit -->
        <!-- ----------------------------------- -->
        <div class="card-footer py-3 bg-transparent border-0 d-flex justify-content-end">
            <button type="submit" id="submit-two-factor-enable-form" form="two-factor-enable-form" class="btn btn-dark px-30 py-12 rounded-3 fw-medium fs-13">تأیید و فعال‌سازی</button>
        </div>
    </div>

@endsection
