@extends('authkit::layouts.dashboard')

@section('page_title', 'کدهای بازیابی تأیید دو مرحله‌ای')

@vite(['resources/js/dashboard/regenerate-recovery-codes.js', 'resources/js/dashboard/disable-two-factor.js'], 'vendor/authkit/build')

@section('content')

    <!-- ----------------------------------- -->
    <!-- Two-Factor Recovery Codes -->
    <!-- ----------------------------------- -->
    <div class="card">

        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h3 class="m-0 fw-bold fs-18">کدهای بازیابی تأیید دو مرحله‌ای</h3>
            <a href="{{ route('dashboard') }}" class="p-1">
                <x-authkit::icons.arrow-left-icon color="var(--secondary)" />
            </a>
        </div>

        <div class="card-body p-4">

            <!-- ----------------------------------- -->
            <!-- Important Notice -->
            <!-- ----------------------------------- -->
            <h6 class="fs-14 fw-bold text-dark mb-2">تذکر مهم</h6>

            <ul class="text-secondary fw-light fs-14 mb-0 ps-4">
                <li>کدهای بازیابی را در مکانی امن نگهداری کنید و در اختیار دیگران قرار ندهید.</li>
                <li>در صورت عدم دسترسی به اپلیکیشن احراز هویت، از یکی از این کدها برای ورود استفاده کنید.</li>
                <li>هر کد فقط یک‌بار قابل استفاده است؛ در صورت گم‌کردن کدها و ازدست‌دادن دسترسی به اپلیکیشن، امکان بازیابی حساب وجود ندارد.</li>
            </ul>

            <!-- ----------------------------------- -->
            <!-- Recovery Codes -->
            <!-- ----------------------------------- -->
            <div id="recovery-codes" class="mt-3 bg-light p-16 rounded-3 border border-light">

                @forelse (session('recovery_codes', []) as $recovery_code)
                    <div class="position-relative d-flex align-items-center justify-content-center py-1">
                        <span class="fw-medium font-monospace text-center" dir="ltr">
                            {{ $recovery_code }}
                        </span>

                        <button type="button"
                                class="btn p-1 position-absolute"
                                style="left: 0; top: 50%; transform: translateY(-50%);"
                                data-code="{{ $recovery_code }}"
                                aria-label="کپی کد بازیابی">
                            <span class="copy-icon">
                                <x-authkit::icons.copy-icon color="var(--secondary)" />
                            </span>
                            <span class="tick-icon d-none">
                                <x-authkit::icons.tick-icon color="var(--success)" />
                            </span>
                        </button>
                    </div>
                @empty
                    <p class="text-secondary fw-light fs-14 mb-0">
                        کد بازیابی جدیدی برای نمایش وجود ندارد.<br>
                        برای دریافت کدهای جدید، روی «تولید کدهای جدید» کلیک کنید.
                        کدهای قبلی با تولید مجموعه جدید باطل می‌شوند.
                    </p>
                @endforelse

            </div>

        </div>

        <!-- ----------------------------------- -->
        <!-- Recovery Code Template -->
        <!-- ----------------------------------- -->
        <template id="recovery-code-template">
            <div class="position-relative d-flex align-items-center justify-content-center py-1">
                <span class="fw-medium font-monospace text-center" dir="ltr"></span>

                <button type="button"
                        class="btn p-1 position-absolute"
                        style="left: 0; top: 50%; transform: translateY(-50%);"
                        aria-label="کپی کد بازیابی">
                    <span class="copy-icon">
                        <x-authkit::icons.copy-icon color="var(--secondary)" />
                    </span>
                    <span class="tick-icon d-none">
                        <x-authkit::icons.tick-icon color="var(--success)" />
                    </span>
                </button>
            </div>
        </template>

        <!-- ----------------------------------- -->
        <!-- Actions -->
        <!-- ----------------------------------- -->
        <div class="card-footer py-3 bg-transparent border-0 d-flex justify-content-end flex-wrap gap-2">

            <form id="regenerate-recovery-codes-form" action="{{ route('two-factor.recovery-code.regenerate') }}" method="POST">
                @csrf
                <button id="submit-regenerate-recovery-codes" type="submit" class="btn btn-outline-dark px-30 py-12 rounded-3 fw-medium fs-13">
                    تولید کد جدید
                </button>
            </form>

            <form id="disable-two-factor-form" action="{{ route('two-factor.disable') }}" method="POST">
                @csrf
                <button id="submit-disable-two-factor" type="submit" class="btn btn-outline-danger px-30 py-12 rounded-3 fw-medium fs-13">
                    غیرفعال‌سازی
                </button>
            </form>

        </div>

    </div>
@endsection