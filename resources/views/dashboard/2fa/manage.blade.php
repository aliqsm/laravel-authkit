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

       <div id="recovery-codes" class="mt-3 bg-light p-16 rounded-3 border border-light">
    @forelse (session('recovery_codes', []) as $recovery_code)
        <div class="d-flex align-items-center justify-content-center gap-2 py-1">
            <span class="fw-medium font-monospace text-center" dir="ltr">
                {{ $recovery_code }}
            </span>

            <button type="button" class="btn p-1 copy-recovery-code" data-code="{{ $recovery_code }}">
                <span class="copy-icon">
                    <x-authkit::icons.copy-icon />
                </span>
                <span class="tick-icon d-none">
                    <x-authkit::icons.tick-icon />
                </span>
            </button>
        </div>
    @empty
        <p class="text-secondary fw-light fs-14 mb-0">
            کد بازیابی جدیدی برای نمایش وجود ندارد.<br>
            برای دریافت کدهای جدید، روی «تولید کدهای جدید» کلیک کنید.
            کدهای قبلی با تولید مجموعه جدید باطل می‌شوند.ti
        </p>
    @endforelse
</div>

<template id="recovery-code-template">
    <div class="d-flex align-items-center justify-content-center gap-2 py-1">
        <span class="fw-medium font-monospace text-center" dir="ltr"></span>

        <button type="button" class="btn p-1 copy-recovery-code">
            <span class="copy-icon">
                <x-authkit::icons.copy-icon />
            </span>
            <span class="tick-icon d-none">
                <x-authkit::icons.tick-icon />
            </span>
        </button>
    </div>
</template>

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
