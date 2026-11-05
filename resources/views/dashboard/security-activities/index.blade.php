@extends('authkit::layouts.dashboard')
@section('page_title', 'فعالیت‌های امنیتی')

@dd($activities)

@section('content')

    <!-- ----------------------------------- -->
    <!-- Security Activities -->
    <!-- ----------------------------------- -->
    <div class="card">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <div>
                <h3 class="m-0 fw-bold fs-18">فعالیت‌های امنیتی</h3>
                <small class="text-secondary fs-13">۲۰ فعالیت امنیتی اخیر حساب شما</small>
            </div>

            <a href="{{ route('dashboard') }}" class="p-1">
                <x-authkit::icons.arrow-left-icon color="var(--secondary)" />
            </a>
        </div>


        <div class="card-body p-0">
            @forelse ($activities as $activity)
                @php
                    $action = match ($activity->data['event'] ?? '') {
                        'login_alert' => 'ورود به حساب کاربری',
                        'password_changed' => 'تغییر رمز عبور',
                        'password_reset' => 'بازیابی رمز عبور',
                        'two_factor_enabled' => 'فعال‌سازی تأیید دومرحله‌ای',
                        'two_factor_disabled' => 'غیرفعال‌سازی تأیید دومرحله‌ای',
                        '2fa_recovery_codes_regenerated' => 'تولید مجدد کدهای بازیابی',
                        '2fa_recovery_codes_empty' => 'اتمام کدهای بازیابی',
                        default => $activity->data['title'] ?? 'فعالیت امنیتی',
                    };
                @endphp
                <div class="d-flex align-items-start gap-3 p-3 border-bottom">
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-3 bg-body-secondary" style="width: 44px; height: 44px;">
                        <x-authkit::icons.security-icon :width="24" :height="24" color="var(--secondary)" />
                    </div>

                    <div class="d-flex flex-column gap-2 flex-grow-1 overflow-hidden">
                        <span class="fw-medium fs-14 text-body">{{ $action }}</span>
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            <small class="text-secondary fs-13">{{ $activity->created_at?->format('H:i - Y/m/d') }}</small>
                            <small class="text-secondary fs-13" dir="ltr">IP: {{ $activity->data['ip'] ?? '-' }}</small>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <small class="text-secondary">هنوز فعالیت امنیتی ثبت نشده است</small>
                </div>
            @endforelse
        </div>
    </div>

@endsection
