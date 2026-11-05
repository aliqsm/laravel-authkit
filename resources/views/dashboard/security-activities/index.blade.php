@extends('authkit::layouts.dashboard')
@section('page_title', 'فعالیت‌های امنیتی')

@section('content')

    <!-- ----------------------------------- -->
    <!-- Security Activities -->
    <!-- ----------------------------------- -->
    <div class="card">

        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <div>
                <h3 class="m-0 fw-bold fs-18">فعالیت‌های امنیتی</h3>
                <span class="text-secondary fs-13">۲۰ فعالیت امنیتی اخیر حساب شما</span>
            </div>

            <a href="{{ route('dashboard') }}" class="p-1">
                <x-authkit::icons.arrow-left-icon color="var(--secondary)" />
            </a>
        </div>

        <div class="card-body p-3 p-md-4">

            @forelse ($activities as $activity)
                @php
                    $event = $activity->data['event'] ?? '';

                    $action = match ($event) {
                        'login_alert' => 'ورود به حساب کاربری',
                        'password_changed' => 'تغییر گذرواژه',
                        'two_factor_enabled' => 'فعال‌سازی تأیید دومرحله‌ای',
                        'two_factor_disabled' => 'غیرفعال‌سازی تأیید دومرحله‌ای',
                        '2fa_recovery_codes_regenerated' => 'تولید مجدد کدهای بازیابی',
                        '2fa_recovery_codes_empty' => 'اتمام کدهای بازیابی',
                        default => $activity->data['title'] ?? 'فعالیت امنیتی',
                    };

                    $isImportant = in_array($event, ['login_alert', 'password_changed', 'two_factor_disabled', '2fa_recovery_codes_empty']);
                @endphp

                <div class="d-flex align-items-center gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <!-- Icon -->
                    <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-3 bg-body-secondary" style="width: 44px; height: 44px;">
                        <x-authkit::icons.security-icon :width="23" :height="23" color="var(--secondary)" />
                    </div>

                    <!-- Activity Information -->
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="fw-medium fs-14 text-body">{{ $action }}</span>

                            @if ($isImportant)
                                <span class="badge bg-danger-subtle text-danger fw-medium fs-11">مهم</span>
                            @endif
                        </div>

                        <span class="text-secondary fs-12 d-block mt-1">{{ $activity->created_at?->format('H:i - Y/m/d') }}</span>
                    </div>

                </div>
            @empty
                <div class="text-center py-5">
                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-body-secondary mx-auto mb-3" style="width: 54px; height: 54px;">
                        <x-authkit::icons.security-icon :width="26" :height="26" color="var(--secondary)" />
                    </div>
                    <span class="text-secondary fs-13">هنوز فعالیت امنیتی ثبت نشده است</span>
                </div>
            @endforelse

        </div>
    </div>

@endsection
